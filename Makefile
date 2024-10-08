include make.conf
# Variables from make.conf:
#
# DOCKER_REPO
SHELL := /bin/bash
APPNAME := url_shortener

REQS := sassc msgfmt
K := $(foreach r, ${REQS}, $(if $(shell command -v ${r} 2> /dev/null), '', $(error "${r} not installed")))

LANGUAGES := $(wildcard language/*/LC_MESSAGES)
JAVASCRIPT := $(shell find public -name '*.js' ! -name '*-*.js')
SASS := $(shell find . -name screen.scss -not -path '*/build/*')
CSS := $(patsubst %.scss, %-$(VERSION).css, $(SASS))

VERSION := $(shell cat VERSION | tr -d "[:space:]")
COMMIT := $(shell git rev-parse --short HEAD)

default: clean compile package

clean:
	rm -Rf build/${APPNAME}*

	rm -Rf public/css/.sass-cache
	for f in $(shell find public/css  -name 'screen-*.css*'); do rm $$f; done
	for f in $(shell find public/js   -name '*-*.js'       ); do rm $$f; done

compile: $(CSS)
	for f in ${JAVASCRIPT}; do cp $$f $${f%.js}-${VERSION}.js; done
	cd ${LANGUAGES} && msgfmt -cv *.po

$(CSS): $(SASS)
	cd $(@D) && sassc -t compact -m screen.scss screen-${VERSION}.css

test:
	vendor/phpunit/phpunit/phpunit -c src/Test/Unit.xml

package:
	[[ -d build ]] || mkdir build
	rsync -rl --exclude-from=buildignore . build/${APPNAME}
	cd build && tar czf ${APPNAME}-${VERSION}.tar.gz ${APPNAME}

dockerdeployment:
	docker build build/${APPNAME} --platform=linux/amd64 -t ${DOCKER_REPO}/${APPNAME}:${VERSION}-${COMMIT}
	docker push ${DOCKER_REPO}/${APPNAME}:${VERSION}-${COMMIT}

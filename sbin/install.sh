#!/bin/bash -x
#
# Install mediaWiki
#

OPENTHC_WIKI_ROOT="/opt/openthc/wiki"
OPENTHC_WIKI_SOURCE="https://releases.wikimedia.org/mediawiki/1.35/mediawiki-1.35.0.tar.gz"

mkdir -p "$OPENTHC_WIKI_ROOT"
cd "$OPENTHC_WIKI_ROOT"

filename=$(basename "$OPENTHC_WIKI_SOURCE")
pathname=$(basename "$filename" ".tar.gz")

if [ ! -d "$pathname" ]
then
	if [ ! -f "$filename" ]
	then
		wget -q "$OPENTHC_WIKI_SOURCE"
	fi

	tar -zxf "$filename"

fi

ln -s $(readlink -f ./LocalSettings.php) "$pathname/LocalSettings.php"
ln -s $(readlink -f ./skins/OpenTHC) "$pathname/skins/OpenTHC"
ln -s "$pathname" ./webroot

chown -R openthc:openthc .
chown -R www-data:www-data "$pathname/images/"



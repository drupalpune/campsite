#!/usr/bin/env bash
set -e

echo "Install mkcert."
wget -nv https://github.com/FiloSottile/mkcert/releases/download/v1.4.0/mkcert-v1.4.0-linux-amd64
sudo mv mkcert-v1.4.0-linux-amd64 /usr/bin/mkcert
chmod +x /usr/bin/mkcert
mkcert -install

echo "Install ddev."
curl -s -LO https://raw.githubusercontent.com/drud/ddev/master/scripts/install_ddev.sh && bash install_ddev.sh v1.17.1
curl -s -L https://raw.githubusercontent.com/drud/ddev/master/scripts/install_ddev.sh | bash
rm install_ddev.sh

echo "Configuring ddev."
mkdir ~/.ddev
docker network create ddev_default || ddev logs

ddev composer install || ddev logs

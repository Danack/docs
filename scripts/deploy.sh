
environment="centos_guest,dev"

if [ "$#" -ge 1 ]; then
    environment=$1
fi

find . -name "*.sh" -exec chmod 755 {} \;

su docs -c "./scripts/deployAsUser.sh ${environment}"

sh ./autogen/addConfig.sh
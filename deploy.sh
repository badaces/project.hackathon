#!/bin/bash

declare -a OPTIONS

ROOT_DIR=/var/www
GIT_URL=git@github.com:badaces/project.hackathon.git

display_usage() {
    cat <<EOF -
Usage: deploy.sh [OPTION]...

Deploys the hackathon application from its git repository.

    -u, --update            Refresh the git repository
    -d, --deploy            Sync files
    -h, --help              Displays this message
EOF
}

display_formatted() {
    local color=$1
    local data=$2

    tput bold
    tput setaf $color
    echo $data
    tput sgr0
}

display_error() {
    local data=$1

    display_formatted 1 "ERROR: $data"
}

display_warning() {
    local data=$1

    display_formatted 3 "WARNING: $data"
}

display_success() {
    local data=$1

    display_formatted 2 "$data"
}

update() {
    cd $ROOT_DIR

    if [ ! -d $ROOT_DIR/.git ]; then
        echo 'update: Removing deploy.sh'
        rm deploy.sh

        echo 'update: Cloning repository'
        git clone $GIT_URL .
    fi

    echo 'update: Resetting repository'
    git reset --hard

    echo 'update: Pulling latest repository changes'
    git pull

    echo 'update: Setting deploy.sh as executable'
    chmod +x deploy.sh
}

deploy() {
    cd $ROOT_DIR

    echo 'deploy: Installing composer dependencies'
    composer install

    echo 'deploy: '
    sass --update -f /var/www/html/web/sass/:/var/www/html/web/css

    bin/phinx migrate

    php app/console.php import:temperature_data
    php app/console.php import:methane_data
    php app/console.php import:co2_data
}

run_program() {
    OPTIONS_SPECIFIED=0

    for OPTION in ${OPTIONS[@]}
    do
        if [ $OPTION != '' ]; then
            OPTIONS_SPECIFIED=1

            $OPTION
        fi
    done

    if [ $OPTIONS_SPECIFIED -ne 1 ]; then
        display_usage
        exit 1
    fi

    display_success 'Program ran successfully'
}

for OPTION in $*
do
    case $OPTION in
        -u|--update)
            OPTIONS[1]=update
        ;;
        -d|--deploy)
            OPTIONS[2]=deploy
        ;;
        --help)
            display_usage
            exit 1
        ;;
    esac
done

run_program

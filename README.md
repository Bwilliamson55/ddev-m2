# DDEV Magento 2.4.5 boilerplate
Currently, with Varnish and Elasticsearch.  
Redis may be next, but it's easy to add via
```shell
ddev get drud/ddev-redis
ddev restart
```
[DDEV Redis repository](https://github.com/ddev/ddev-redis)

Use `ddev redis-cli` for the redis cli.

# About
This boierplate is to stand up a new local Magento 2.4.5 instance from scratch quickly.

This is essentially the [Official DDEV quickstart guide](https://ddev.readthedocs.io/en/stable/users/quickstart/#magento-2) - with some add-ons and a Varnish VCL in place already.

# Installation
1. Make a folder, cd into it, clone the repo
```bash
git clone git@github.com:bwilliamson55/ddev-m2.git ./m2-project
```
2. Run `ddev start` and wait for it to finish.
3. Create your project with composer
```bash
ddev composer create --repository=https://repo.magento.com/ magento/project-community-edition:2.4.5 -y 
```
4. Follow the prompts to enter your Magento credentials.
   ### A note about auth.json
If you want sample data, it's easiest to create an `auth.json` file at the root of your project with your marketplace credentials in it.  
I do NOT commit this file.  See [the official docs on how to get these or create them](https://experienceleague.adobe.com/docs/commerce-cloud-service/user-guide/develop/authentication-keys.html?lang=en)
```
{
  "http-basic": {
    "repo.magento.com": {
      "username":"public key",
      "password":  "private key"
    }
  }
}
```
5. Run the Magento installer - REPLACE:
    - the base-url with your project's URL - It's the projects name, in this case, `m2-project.ddev.site`
    - the admin email, username, and password with your own
    - the admin URI with your own

First, SSH into the web container:
```bash 
ddev ssh
```
Then run the installer:
```bash
bin/magento setup:install \
    --base-url='https://m2-project.ddev.site/' \
    --cleanup-database \
    --db-host=db \
    --db-name=db \
    --db-user=db \
    --db-password=db \
    --elasticsearch-host=elasticsearch \
    --admin-firstname=Admin \
    --admin-lastname=Admin \
    --admin-email=Admin@admin.com \
    --admin-user=admin \
    --admin-password=Password1! \
    --language=en_US \
    --currency=USD \
    --timezone=America/New_York \
    --use-rewrites=1 \
    --backend-frontname=admin \
    --amqp-host="rabbitmq" \
    --amqp-port="5672" \
    --amqp-user="rabbitmq" \
    --amqp-password="rabbitmq" \
    --amqp-virtualhost="/"
```
6. Run the following to configure and finalize the installation
```bash
bin/magento deploy:mode:set developer
bin/magento config:set admin/security/password_is_forced 0
bin/magento config:set admin/security/password_lifetime 0
bin/magento module:disable Magento_TwoFactorAuth

# Configure Varnish
bin/magento config:set --scope=default --scope-code=0 system/full_page_cache/caching_application 2
#Configure RabbitMQ
bin/magento setup:config:set --amqp-host="rabbitmq" --amqp-port="5672" --amqp-user="rabbitmq" --amqp-password="rabbitmq" --amqp-virtualhost="/"

# Deploy sample data if you like
bin/magento sampledata:deploy
# If you have troubles with authentication, add a auth.json file to the root of the project with your Magento credentials
eg 
{
    "http-basic": {
        "repo.magento.com": {
            "username": "your-username",
            "password": "your-password"
        }
    }
}

# Rain dance
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento indexer:reindex
# cache:flush
bin/magento c:f
# Back to host cli
exit

# Let ddev change things in the config again
ddev config --disable-settings-management=false
```
7. Restart ddev
```bash
ddev restart
```
8. Visit your site at `https://m2-project.ddev.site/` and login at `https://m2-project.ddev.site/admin`
 
# Varnish
Varnish is configured via the `.ddev/varnish/default.vcl` file. 

Watch the log stream with `ddev varnishlog`
If you flush the cache (`ddev magento c:f`) during this time, you should see the PURGE event in the log stream.

For troubleshooting, check out the repository readme for all the CLI commands: [https://github.com/ddev/ddev-varnish](https://github.com/ddev/ddev-varnish)  
The only issue I've run into was a 503 "Backend fetch failed" error.  This was due to the health probe considering the backend as down.

# Note for 2.4.6 branch
To configure opensearch after `ddev restart` run
```bash
bin/magento config:set catalog/search/engine opensearch
bin/magento config:set catalog/search/opensearch_server_hostname http://opensearch
bin/magento config:set catalog/search/opensearch_server_port 9200
bin/magento config:set catalog/search/opensearch_index_prefix magento2
bin/magento config:set catalog/search/opensearch_enable_auth 0
bin/magento config:set catalog/search/opensearch_server_timeout 15
```

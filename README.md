# DDEV Magento 2.4.5 boilerplate
Currently, with Varnish and Elasticsearch.  
Redis may be next, but it's easy to add via
```shell
ddev get drud/ddev-redis
ddev restart
```
[DDEV Redis repository](https://github.com/ddev/ddev-redis)

Use `ddev redis-cli` for the redis cli.

# What
This boierplate is to stand up a new local Magento 2.4.5 instance from scratch quickly.

This is essentially the [Official DDEV quickstart guide](https://ddev.readthedocs.io/en/stable/users/quickstart/#magento-2) - with some add-ons and a Varnish VCL in place already.

# Installation
1. Make a folder, cd into it, clone the repo
```bash
mkdir m2-project && cd $_
git clone git@github.com:bwilliamson55/ddev-m2.git . 
```
2. Run `ddev start` and wait for it to finish.
3. Create your project with composer
```bash
ddev composer create --repository=https://repo.magento.com/ magento/project-community-edition:2.4.5 -y 
```
4. Follow the prompts to enter your Magento credentials.
5. Run the Magento installer - REPLACE:
    - the base-url with your project's URL - It's the projects name, in this case, `m2-project.ddev.site`
    - the admin email, username, and password with your own
    - the admin URI with your own
```bash
ddev magento setup:install \
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
    --backend-frontname=admin
```
6. Run the following to configure and finalize the installation
```bash
ddev magento deploy:mode:set developer
ddev magento config:set admin/security/password_is_forced 0
ddev magento config:set admin/security/password_lifetime 0
ddev magento module:disable Magento_TwoFactorAuth

# Configure Varnish
ddev magento config:set --scope=default --scope-code=0 system/full_page_cache/caching_application 2

# Rain dance
ddev magento setup:upgrade
ddev magento setup:di:compile
ddev magento indexer:reindex
ddev magento c:c
# Let ddev change things in the config again
ddev config --disable-settings-management=false
```
7. Restart ddev
```bash
ddev restart
```
8. Visit your site at `https://m2-project.ddev.site/` and login at `https://m2-project.ddev.site/admin`

# Varnish
Varnish is configured via the `.ddev/varnish/default.vcl` file.  It's configured to cache everything except the admin and graphql.  If you want to cache graphql, you'll need to edit the `default.vcl` file.

Watch the log stream with `ddev varnishlog`
If you flush the cache (`ddev magento c:f`) during this time, you should see the PURGE event in the log stream.

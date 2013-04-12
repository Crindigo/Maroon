set :application, "Maroon RPG"
set :domain,      "domain.tld"
set :deploy_to,   "/path/to/folder"
set :user,        "ssh_user"
set :app_path,    "app"

set :repository,  "git@github.com:Username/Maroon.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain        # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server
#role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set :keep_releases,  3

set :use_sudo, false
set :dump_assetic_assets, true
set :shared_files, ["app/config/parameters.yml"]
set :shared_children, [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true
set :branch, "master"
set :group_writable, false
default_run_options[:pty] = true
#before "symfony:cache:warmup", "symfony:doctrine:migrations:migrate"

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

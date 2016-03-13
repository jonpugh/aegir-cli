# Aegir CLI Proposal

This project was called "Terra CLI". 

It was originally built with the thought that it could be aegir 4.

The author named it "terra" so that we could try radical new things like
a total rewrite.

So, here is what we envision to be the path forward for aegir:

- Everything in Composer & Packagist.
- Everything decoupled.
- Everything abstracted: Aegir's main benefit is extensibility. Choose 
Apache vs NGINX. Keep the system extensible to support future platforms 
like containers.

# Aegir CLI
## `aegir/cli`

http://github.com/jonpugh/aegir-cli

Simple command line tool for managing everything.  The "Terra CLI" has
been donated as a starting point.

# Aegir Provision
## `aegir/provision`
http://github.com/jonpugh/aegir-provision

Classes & Models for Server, Service, Project, Environment, Task.

Metadata is stored in YML files in the active users home directory.

Every first class thing gets a Class in this project.

This code will define the pattern for creating "AegirService" and
"AegirEnvironment" classes.

These classes must be extensible.

# Aegir Hostmaster

- `aegir/hostmaster`
- `aegir/hostmaster-tasks`
- `aegir/hostmaster-servers`
- `aegir/hostmaster-environments`

Collection of (DECOUPLED!) drupal modules that provide the front-end 
experience and REST APIs for Aegir.

We propose we deprecate the name "hosting" for this code. It's always 
been confusing for developers and customers alike.
CHANGELOG


Version 1.3.0 [2018-07-01]:
 - Adding allBranchStatuses() && allPullRequestStatuses() + deprecating old ones
 - Adding allPullRequests() and deprecating old one
 - Adding allMilestones() and deprecating old one
 - Adding allLabels() and deprecating old one
 - Adding allBranches() and deprecating old one

Version 1.2.0 [2018-06-25]:
 - Ugpgrading phpstan (0.10) & infection (0.9dev)
 - Upgrade devboard/lib-github, min is now 1.1
 - PHPStan: Ignore json decode expectations
 - Ignore errors with reading json file content in tests
 - Insure datetime is given as integer
 - Save environment variables to local variables and use them to check existance

Version 1.1.0 [2018-06-21]:

 - JwtTokenAuth should be serializable
 - Add simple API endpoint that will return user installations
 - Add simple api to fetch all repositories of installation
 - Deprecated InstallationsApi->fetch()
 - Deprecate InstallationRepositoriesApi->fetch()

Version 1.0: Up to this point, there is no documentation on given code but we do hope to fix that soon :)


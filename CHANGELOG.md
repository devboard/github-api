CHANGELOG

Version 1.4.1 [2018-07-15]:

 - Update test data from 3rd party repos (mostly without PRs :( )

Version 1.4.0 [2018-07-15]:

 - Add cursor to all existing GraphQL queries #64
 - Update testdata with changes from #58,#59,#60
 - We dont need branch id when fetching branches #59
 - We dont need repository id or name when fetching branches #59
 - Remove various urls when fetching branches #59
 - Fetch commit signature information when fetching branches #58
 - Add PageInfo to GraphQL queries missing it #60

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


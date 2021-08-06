# Contributing to Bubble

## Welcome!

We look forward to your contributions! Here are some examples how you can contribute:

* [Report a bug](https://github.com/Ahmed-Ibrahimm/BubbleTemplateEngine/issues/new?assignees=&labels=&template=---bug-report.md)
* [Propose a new feature](https://github.com/Ahmed-Ibrahimm/BubbleTemplateEngine/issues/new?assignees=&labels=&template=---feature-request.md)
* [Send a pull request](https://github.com/Ahmed-Ibrahimm/BubbleTemplateEngine/pulls)


## We have a Code of Conduct

Please note that this project is released with a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in this project you agree to abide by its terms.


## Any contributions you make will be under the BSD-3-Clause License

When you submit code changes, your submissions are understood to be under the same [BSD-3-Clause License](https://github.com/Ahmed-Ibrahimm/BubbleTemplateEngine/blob/main/LICENSE) that covers the project. By contributing to this project, you agree that your contributions will be licensed under its BSD-3-Clause License.


## Write bug reports with detail, background, and sample code

In your bug report, please provide the following:

* A quick summary and/or background
* Steps to reproduce
    * Be specific!
    * Give sample code if you can.
* What you expected would happen
* What actually happens
* Notes (possibly including why you think this might be happening, or stuff you tried that didn't work)

Please post code and output as text ([using proper markup](https://guides.github.com/features/mastering-markdown/)). Do not post screenshots of code or output.

Please include the output of `composer info | sort` if you installed Bubble using Composer.

Please use the most specific issue tracker to search for existing tickets and to open new tickets:

* [General problems](https://github.com/Ahmed-Ibrahimm/BubbleTemplateEngine/issues)
* [Documentation](https://bubble.dinophp.com/docs)
* [Website](https://bubble.dinophp.com/)


## Workflow for Pull Requests

1. Fork the repository.
2. Create your branch from `master` if you plan to implement new functionality or change existing code significantly; create your branch from the oldest branch that is affected by the bug if you plan to fix a bug.
3. Implement your change and add tests for it.
4. Ensure the test suite passes.
5. Ensure the code complies with our coding guidelines (see below).
6. Send that pull request!

Please make sure you have [set up your user name and email address](https://git-scm.com/book/en/v2/Getting-Started-First-Time-Git-Setup) for use with Git. Strings such as `silly nick name <root@localhost>` look really stupid in the commit history of a project.

We encourage you to [sign your Git commits with your GPG key](https://docs.github.com/en/github/authenticating-to-github/signing-commits).

Pull requests for bug fixes must be made for the oldest branch that is [supported](https://phpunit.de/supported-versions.html). Pull requests for new features must be based on the `master` branch.

We are trying to keep backwards compatibility breaks in PHPUnit to an absolute minimum. Please take this into account when proposing changes.

Due to time constraints, we are not always able to respond as quickly as we would like. Please do not take delays personal and feel free to remind us if you feel that we forgot to respond.

## Using Bubble from a Git checkout

The following commands can be used to perform the initial checkout of Bubble:

```bash
$ git clone git://github.com/Ahmed-Ibrahimm/BubbleTemplateEngine.git

$ cd BubbleTemplateEngine
```

Install Bubble's dependencies using [Composer](https://getcomposer.org/):
Sweelix Node management
=======================

Sweelix node management is an implementation of Rational numbers to key nested sets
by Dan Hazel (http://arxiv.org/abs/0806.3115).


[![Latest Stable Version](https://poser.pugx.org/sweelix/tree/v/stable)](https://packagist.org/packages/sweelix/tree)
[![Build Status](https://travis-ci.org/pgaultier/tree.svg?branch=master)](https://travis-ci.org/pgaultier/tree)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pgaultier/tree/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pgaultier/tree/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/pgaultier/tree/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/pgaultier/tree/?branch=master)
[![License](https://poser.pugx.org/sweelix/tree/license)](https://packagist.org/packages/sweelix/tree)

[![Latest Development Version](https://img.shields.io/badge/unstable-devel-yellowgreen.svg)](https://packagist.org/packages/sweelix/tree)
[![Build Status](https://travis-ci.org/pgaultier/tree.svg?branch=devel)](https://travis-ci.org/pgaultier/tree)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pgaultier/tree/badges/quality-score.png?b=devel)](https://scrutinizer-ci.com/g/pgaultier/tree/?branch=devel)
[![Code Coverage](https://scrutinizer-ci.com/g/pgaultier/tree/badges/coverage.png?b=devel)](https://scrutinizer-ci.com/g/pgaultier/tree/?branch=devel)


Installation
------------

If you use Packagist for installing packages, then you can update your composer.json like this :

``` json
{
    "require": {
        "sweelix/tree": "*"
    }
}
```

Howto use it
------------

Create a Node class and attach the NodeTrait to it. You can look at the class ```Node```.

``` php
use sweelix\tree\NodeTrait;

class MyNode {
    use NodeTrait;
}
```

Now you can create a node :

``` php
$node = new MyNode();
$node->setPath('1.2.1');

$leftBorder = $node->getLeft();

$rightBorder = $node->getRight();

$treeInfo = $node->getMatrix()->toArray();

// insert your node in DB using leftBorder and rightBorder
// do not forget to also store the tree info

```

Now you can search the node in your DB using regular nested set methods :

```sql
# find all the children
select * from nodes where left > :nodeLeft and right < :nodeRight order by nodeLeft;

# find all the parents
select * from nodes where left < :nodeLeft and right > :nodeRight order by nodeRight;

```


Contributing
------------

All code contributions - including those of people having commit access -
must go through a pull request and approved by a core developer before being
merged. This is to ensure proper review of all the code.

Fork the project, create a [feature branch ](http://nvie.com/posts/a-successful-git-branching-model/), and send us a pull request.

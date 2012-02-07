$Id: README.txt,v 1.6 2008/06/18 14:44:15 kbahey Exp $

Copyright 2006 http://2bits.com

This module allows users to add certain nodes to a favorite list.
Each node has an "add to favorites" link at the bottom.
This favorite list is visible to others viewing the site.

The admin can specify which type of nodes are allowed to be
added to favorites by users.

Views integration provide the following:
- Filter for current users (my favorite nodes)
- Filter for all nodes that have been added to favorites by any user.
- A field that shows how many users have added the node to favorites,
  useful as an indication for popularity.
- An argument that allows filtering of Favorites nodes for a specific user.
  This is useful to show "editor's picks" and such type of lists.

Installation
------------
To install this module, Upload or copy the the entire favorite_nodes directory and 
all its contents to your modules directory.

Configuration
-------------
To enable this module do the following:

1. Go to Administer -> Site building -> Modules, and enable favorite_nodes.

2. Go to Administer -> User management -> Access control and enable for the roles you want.

3. Go to Administer -> Site configuration -> Favorite nodes and configure the 
   node types that are allowed to be added to favorites.

Bugs/Features/Patches:
----------------------
If you want to report bugs, feature requests, or submit a patch, please do so
at the project page on the Drupal web site.

Author
------
Khalid Baheyeldin (http://baheyeldin.com/khalid and http://2bits.com)

If you use this module, find it useful, and want to send the author
a thank you note, then use the Feedback/Contact page at the URL above.

The author can also be contacted for paid customizations of this
and other modules.

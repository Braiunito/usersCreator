# How to compile scss

1. Have gem installed (`https://guides.rubygems.org/command-reference/#gem-install`).
2. Have compass installed (`http://compass-style.org/install/`).
3. Go into `./public/templates/assets/theme` and run `compass watch`.

## **NEVER MODIFY DIRECTLY THE CSS FILES**

4. In order to apply a modification, change the `.scss` that you need inside in the mentioned folder.

# Why are templates that don't extend from base.hml?

This is a little trick to use those templates as ajax-html forms and insert it into other twig templates in some AJAX requests to perform the UX.
(Sorry for that!).
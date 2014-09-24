# -*- coding: utf-8 -*-

import sys, os

# Project settings:
project = u'Suggester 2015'
author = u'Jacek Siciarek'
copyright = u'2014, Jacek Siciarek'
version = '1.0'
release = version

# Layout settings:
language = 'english'
templates_path = ['_templates']
exclude_patterns = ['_build']
master_doc = 'index'
html_theme = 'nature'
html_sidebars = {'**': ['localtoc.html', 'relations.html']}
html_logo = 'images/logo.png'

# -- Options for LaTeX output --------------------------------------------------

latex_elements = {
# The paper size ('letterpaper' or 'a4paper').
'papersize': 'a4paper',

# The font size ('10pt', '11pt' or '12pt').
'pointsize': '12pt',

# Additional stuff for the LaTeX preamble.
#'preamble': '',

'babel': '\\usepackage[' + language + ']{babel}',
'classoptions': ',openany,oneside'
}

# Grouping the document tree into LaTeX files. List of tuples
# (source start file, target name, title, author, documentclass [howto/manual]).
latex_documents = [
  (master_doc, 'suggester.tex', project, author, 'manual', False),
]

# The name of an image file (relative to this directory) to place at the top of
# the title page.
latex_logo = 'images/logo.png'

# For "manual" documents, if this is true, then toplevel headings are parts,
# not chapters.
latex_use_parts = False

# If true, show page references after internal links.
latex_show_pagerefs = True

# If true, show URL addresses after external links.
#latex_show_urls = False

# Documents to append as an appendix to all manuals.
#latex_appendices = []

# If false, no module index is generated.
#latex_domain_indices = True

# -----------------------------------------------------------------------------
# http://symfony.com/doc/current/contributing/documentation/format.html
# -----------------------------------------------------------------------------

# ...
sys.path.append(os.path.abspath('_exts'))

# adding PhpLexer
from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer

# ...
# add the extensions to the list of extensions
extensions = ['sensio.sphinx.refinclude', 'sensio.sphinx.configurationblock', 'sensio.sphinx.phpcode']

# enable highlighting for PHP code not between ``<?php ... ?>`` by default
lexers['php'] = PhpLexer(startinline=True)
lexers['php-annotations'] = PhpLexer(startinline=True)
lexers['php-standalone'] = PhpLexer(startinline=True)
lexers['php-symfony'] = PhpLexer(startinline=True)

# use PHP as the primary domain
primary_domain = 'php'

# set url for API links
api_url = 'http://api.symfony.com/master/%s'

# -----------------------------------------------------------------------------

# Custom formats for sensio.sphinx.configurationblock
from sensio.sphinx.configurationblock import ConfigurationBlock
ConfigurationBlock.formats['bash'] = 'Linux'
ConfigurationBlock.formats['bat'] = 'Windows'

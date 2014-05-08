#!/usr/bin/env python

import pxssh
import sys

try:
  s = pxssh.pxssh()
  hostname = sys.argv[1]
  username = 'root'
  password = ''
  s.login (hostname, username, password, login_timeout = 10)
  s.logout()
  print "1"
except:
  print "0"

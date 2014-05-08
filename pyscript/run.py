#!/usr/bin/env python

import pxssh
import sys
import re
                                                            
s = pxssh.pxssh()
hostname = sys.argv[1]
username = 'root'
password = ''
command = re.sub('^:', './', sys.argv[2])
s.login (hostname, username, password)
s.sendline (command)
s.prompt(timeout=300)
print s.before
s.logout()

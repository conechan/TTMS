#!/usr/bin/python
# Filename: host.py
#
# Description:
#
# Get the real host name by IP
#
# Date / Author / Version
#
# Aug 09, 2010 / Charlie Chen / initial version
#
#

import re
import sys
import os

def find_name(raw):
  'find host name from host command raw output via RE'
  str = re.search('\s\w*\.', raw).group()
  name = re.sub('[^\w]', '', str)
  return name

def check_per(raw):
  'check if the host in domain gdntrnd to determine the permission'
  if re.search('rnd.gdnt.local', raw) is not None:
    return True 
  else:
    return False

def get_raw(ip):
  'get the shell command host raw output by ip'
  raw = os.popen('host ' + ip).read()
  return raw


if check_per(get_raw(sys.argv[1])):
  print find_name(get_raw(sys.argv[1]))
else:
  print '0'
#print 'charliechen'



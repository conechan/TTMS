#!/usr/bin/env python

import pexpect

child = pexpect.spawn ('ssh bsmbin@137.117.20.149')
print 'telneting'
child.expect ('Password: ')
child.sendline ('abcde01')
print 'login!'
child.expect ('ebsc20a% ')
child.sendline('bsmci')
child.expect ('BSMCI.*>.*')
child.sendline ('table metroinv')
child.expect ('METROINV.*>.*')
child.sendline ('format packed;lis all')
child.expect ('METROINV.*>.*')
print child.before
child.sendline ('exit')
child.expect ('BSMCI.*>.*')
child.sendline ('exit')
child.expect ('ebsc20a% ')
child.sendline('exit')

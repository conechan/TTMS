import pexpect

ssh_newkey = 'Are you sure you want to continue connecting.*'
host = '137.117.18.168'
child = pexpect.spawn('scp /root/.ssh/id_rsa.pub root@%s:/tmp'%(host))
i = child.expect([pexpect.TIMEOUT, ssh_newkey, 'password: '])
if i == 0:
  print 'TIMEOUT!'
if i == 1:
  print 'Qu!'
  child.sendline ('yes')
  i = child.expect([pexpect.TIMEOUT, 'password: '])
  if i == 0:
      print 'TIMEOUT!'
  if i == 1:
      print 'passwd first'
if i == 2:
  print 'passwd'

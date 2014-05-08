import pexpect
import sys
import pxssh

def scp_command (host, password):
  ssh_newkey = 'Are you sure you want to continue connecting.*'
  child = pexpect.spawn('scp /root/.ssh/id_rsa.pub root@%s:/tmp'%(host))
  i = child.expect([pexpect.TIMEOUT, ssh_newkey, 'password: '])
  if i == 0:
    print 'TIMEOUT!'
    return None
  if i == 1:
    print 'Qu!'
    child.sendline ('yes')
    i = child.expect([pexpect.TIMEOUT, 'password: '])
    if i == 0:
      print 'TIMEOUT!'
      return None
    if i == 1:
      print 'passwd first'
      child.sendline (password)
      return child
  if i == 2:
    print 'passwd'
    child.sendline (password)
    return child
  print 'passed'
  return 0

def ssh_command (host, password):
  s = pxssh.pxssh()
  s.login (host, 'root', password, login_timeout=30)
  s.sendline ('echo "UseDNS no" >> /tmp/tmp.txt')
  s.prompt()
  print s.before
  s.sendline ('cat /tmp/tmp.txt >> /etc/ssh/sshd_config')
  s.prompt()
  print s.before
  s.sendline ('mkdir /root/.ssh/')
  s.prompt()
  print s.before
  s.sendline ('cat /tmp/id_rsa.pub >> /root/.ssh/authorized_keys')
  s.prompt()
  print s.before
  s.sendline ('/etc/init.d/ssh restart')
  s.prompt()
  print s.before
  s.sendline ('/etc/init.d/sshd restart')
  s.prompt()
  print s.before
  s.logout()

def main ():
  host = sys.argv[1]
  password = sys.argv[2]
  child = scp_command (host, password)
  child.expect(pexpect.EOF)
  print child.before
  ssh_command (host, password)

if __name__ == '__main__':
    try:
        main()
    except Exception, e:
        print 'passed or failed'
        print 'if failed, please check if the SSH service is UP on the server.'

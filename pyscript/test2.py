#!/usr/bin/env python

import sys
import re
                                                            
command = re.sub('^#', '', sys.argv[1])
print command

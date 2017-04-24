import os
import sys


arg = sys.argv[1]
fname = "test.txt"
if not os.path.exists(fname):
	fh = open(fname, "w")
	fh.write(str(arg))
	fh.close()


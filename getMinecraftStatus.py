import json, sys
from mcstatus import MinecraftServer

ip_port = sys.argv[1]

# If you know the host and port, you may skip this and use MinecraftServer("example.org", 1234)
server = MinecraftServer.lookup(ip_port)

try:
    status = server.status()
    print(json.dumps(status.raw))
except:
    print(json.dumps({"error": "Can't get status."}))
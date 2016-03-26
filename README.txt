________                   _____          __          
\_   ___ \  ____   ____    /     \ _____ _/  |_  ____  
/    \  \/ /  _ \ /    \  /  \ /  \\__  \\   __\/ __ \ 
\     \___(  <_> )   |  \/    Y    \/ __ \|  | \  ___/ 
 \______  /\____/|___|  /\____|__  (____  /__|  \___  >
        \/            \/         \/     \/          \/ 


ConMate: Configuration Management Through etcd. 
Lightweight utility to integrate etcd into php applications.

Read throught at http://prateek-1708.github.io/ConMate

To try out ConMate on your local systems you need:

* etcd service (follow https://github.com/coreos/etcd/releases/tag/v2.3.0)
* setup mykey => this is awesome as shown in the above guide.
* etcd available on localhost:14001 (if not then change the port in unit tests)

TODO: Add dockerfile for etcd service.
TODO: Add support for all Etcd API calls.
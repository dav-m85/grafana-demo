# Statsd-client + Grafana demo

Simple Demo for a couple Grafana + PHP statsd to show grafana capabilities.
You just need a server running docker and you're good.

## Installation
```bash
# With docker installed, being sudo
git clone ...
cd ...
docker build -t sshd -f sshd.Dockerfile .
docker build -t phps -f phps.Dockerfile .

# Use this lime if you want write access from host:
# docker run -d -p :22 --name test_sshd -v /Users/david/Desktop/arf:/var/www sshd
docker run -d -p :22 --name test_sshd sshd
docker run -d -p 81:80 -p 8125:8125/udp --name test_statsd jakubzapletal/statsd-grafana:1.0.0
docker run -d -p 80:80 --link test_statsd:statsd --name test_phps --volumes-from test_sshd phps
```

Editing files with [codeanywhere](https://codeanywhere.com/) or ssh access is dead simple:
```bash
# Password is screencast, or whatever you set in sshd.Dockerfile
ssh root@my-host-ip:dockerport
```

Generate some test points with siege:
```bash
echo "http://youserverip/" > urls.txt
echo "http://youserverip/a" > urls.txt
echo "http://youserverip/b" > urls.txt
siege -c 3 -t 1M -d 2 -f urls.txt

# Now you should see some interestings points on your dashboard.
```

Then you got:
* Grafana is on your-server-ip:81
* Test pages are on your-server-ip:80

Voilà !

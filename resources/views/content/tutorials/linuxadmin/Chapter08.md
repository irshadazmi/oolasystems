# Chapter 8: Networking Fundamentals and Network Configuration

Learn how to inspect network interfaces, IP addresses, routes, name resolution, listening sockets, and basic connectivity on Linux. The practical exercises focus on diagnostic commands and interpretation rather than changing network configuration or scanning other systems.

> **Lab environment:** Ubuntu on WSL 2, an Ubuntu virtual machine, or an approved browser terminal. Network interfaces and DNS tools vary across environments. Use only your own machine, a lab target, or a destination for which you have explicit permission.

## Learning objectives

By the end of this chapter, you should be able to:

- Explain interfaces, IP addresses, routes, ports, TCP/UDP, and DNS.
- Inspect network addresses and routing information using `ip`.
- Check hostname resolution with available tools.
- Inspect listening sockets and established connections.
- Use connectivity checks carefully and interpret limitations.
- Follow a layered troubleshooting workflow.
- Avoid unauthorised scans, disruptive probes, or configuration changes.

## 1. Industry scenario: an application cannot connect

A developer reports that a Linux application cannot reach a service by hostname. Possible causes include a missing interface address, a route problem, name-resolution failure, a blocked port, an unavailable service, or a restriction in the lab environment. The administrator should inspect each layer in a logical order instead of changing settings at random.

![Linux networking architecture](/images/tutorials/linuxadmin/ch08-linux-networking-architecture.png)

Network troubleshooting often starts with local configuration and proceeds toward the destination: interface/address, route, name resolution, reachability, then the relevant service or port. The order can be adapted to the symptom; a DNS-specific error, for example, may justify checking name resolution earlier.

## 2. Quick reference: Linux networking commands

| Command | Brief description | Common options / notes | Simple examples |
|---|---|---|---|
| `ip addr` | Show network interfaces and addresses. | `-br` gives brief output on common versions. | `ip addr` · `ip -br addr` |
| `ip link` | Show network interface state and link details. | `show` is the default on many versions. | `ip link` |
| `ip route` | Display the IPv4 routing table. | `get DESTINATION` can show route selection. | `ip route` |
| `ip -6 route` | Display IPv6 routes. | Availability depends on configuration. | `ip -6 route` |
| `hostname` | Show or query the system hostname. | `-I` lists configured addresses on many systems. | `hostname` · `hostname -I` |
| `getent hosts NAME` | Query host information through configured name services. | Often available without installing extra tools. | `getent hosts example.com` |
| `nslookup NAME` | Query DNS using an available resolver utility. | May not be installed. | `nslookup example.com` |
| `dig NAME` | Query DNS with detailed output. | Often provided by DNS utility packages; may be absent. | `dig example.com` |
| `resolvectl status` | Show resolver status on systemd-resolved systems. | Not available in every WSL/browser environment. | `resolvectl status` |
| `ping HOST` | Send ICMP echo requests to test reachability. | `-c N` limits request count on common implementations. | `ping -c 4 HOST` |
| `curl -I URL` | Request response headers from an HTTP(S) URL. | Network access and remote policy may limit results. | `curl -I https://example.com` |
| `ss -tuln` | Show listening TCP/UDP sockets and numeric ports. | `-p` may reveal process details but can require permissions. | `ss -tuln` |
| `ss -tun` | Show TCP/UDP sockets without resolving names. | Output depends on active sockets. | `ss -tun` |
| `ip neigh` | Show neighbour/ARP information where relevant. | Cache may be empty or transient. | `ip neigh` |
| `traceroute HOST` | Trace a network path if installed and permitted. | Probes may be filtered; tool may be absent. | Use only on an approved target. |
| `tracepath HOST` | Discover path information on supported systems. | Availability and behaviour vary. | `tracepath HOST` |
| `curl --help` | Display curl help. | Help modes vary. | `curl --help` |
| `man ip` | Read IP command documentation. | Manual pages may not be installed. | `man ip` |

**Safety note:** `ip addr`, `ip route`, `ss`, and `getent hosts` are inspection commands. Commands that add/delete routes, bring interfaces down, change addresses, or alter DNS configuration are outside the scope of this introductory lab.

## 3. Networking concepts in brief

- **Network interface:** a logical or physical connection point, such as Ethernet, Wi-Fi, or a virtual interface.
- **IP address:** a network-layer address assigned to an interface.
- **Subnet/prefix:** describes which addresses are considered part of a local network.
- **Route:** information used to choose where packets should be sent next.
- **Port:** a transport-layer endpoint number used by applications.
- **TCP:** connection-oriented transport that provides ordered, reliable delivery.
- **UDP:** connectionless transport with lower protocol overhead but no built-in delivery guarantee.
- **DNS:** a naming system that helps map hostnames to addresses and other records.

![DNS resolution and routing concepts](/images/tutorials/linuxadmin/ch08-dns-and-routing-concepts.png)

DNS resolution and packet routing are separate steps. A hostname can resolve correctly while the destination remains unreachable; conversely, an IP address may be reachable even when a hostname cannot be resolved.

## 4. Practical lab A — inspect interfaces and addresses

Run:

```bash
hostname
hostname -I
ip addr
ip -br addr
ip link
```

Record:

1. The hostname displayed.
2. One interface name shown by `ip`.
3. Whether the interface appears up or down.
4. An IPv4 or IPv6 address shown, if any.
5. One reason your output may differ from a classmate's.

On WSL2 or a browser terminal, you may see virtual interfaces, private addresses, or a limited interface view. Do not assume that an interface name or address must match the examples in a textbook.

## 5. Practical lab B — inspect routing and name resolution

Run:

```bash
ip route
ip -6 route
getent hosts example.com
```

If available, you may also inspect resolver details:

```bash
resolvectl status
```

If `getent` returns no result, or resolver tooling is unavailable, record that observation. Network access may be disabled in the lab or DNS configuration may differ.

Answer:

- Is a default route shown?
- Which interface is associated with the default route, if one is displayed?
- Did the hostname resolve to an address?
- What is the difference between resolving a hostname and reaching the destination?
- What additional evidence would help explain a failed lookup?

Do not edit DNS configuration or add routes as part of this exercise.

## 6. Practical lab C — connectivity checks

Use only a permitted target. First, test a local or instructor-provided endpoint. If external access is permitted, you may try a single, limited check such as:

```bash
ping -c 4 example.com
curl -I https://example.com
```

The examples are optional and depend on network policy. A host may block ICMP echo requests while still serving HTTPS. A successful ping also does not prove that a particular application port is open.

Interpret the evidence:

| Observation | What it may indicate | What it does not prove |
|---|---|---|
| DNS lookup succeeds | A name-to-address response was obtained. | The service is running or reachable. |
| Ping succeeds | ICMP echo traffic was answered. | A web application or specific port works. |
| Ping fails | ICMP may be blocked, the path may fail, or the host may be unavailable. | The host is definitely down. |
| `curl -I` returns HTTP headers | An HTTP(S) response was received. | All application functions work correctly. |
| Connection is refused | The target was reached but no listener accepted that connection, or a device actively rejected it. | The whole server is down. |
| Connection times out | No timely response was received. | The exact cause without more evidence. |

## 7. Practical lab D — inspect listening sockets

Run:

```bash
ss -tuln
```

Where appropriate, compare with:

```bash
ss -tun
```

The first command commonly shows listening TCP and UDP sockets with numeric addresses and ports. The second shows TCP/UDP sockets without name resolution; output depends on what connections exist at the time.

Complete this worksheet:

| Question | Your notes |
|---|---|
| Which local ports appear to be listening? | |
| Is a listener bound to `127.0.0.1`, `0.0.0.0`, `::1`, or `::`? | |
| What is the practical difference between loopback and a wildcard bind address? | |
| Which process/application might own a listener, if you have permission to inspect it? | |
| Why should you not expose a service just to make a lab test pass? | |

A wildcard bind address generally means listening on available interfaces for that address family, subject to firewall and other controls. Loopback addresses are local to the host. Actual exposure depends on the system's network setup and security controls.

## 8. Layered troubleshooting workflow

![Network connectivity troubleshooting workflow](/images/tutorials/linuxadmin/ch08-connectivity-troubleshooting-workflow.png)

When a connection fails, record the exact error and work through relevant layers:

1. **Interface/address:** is the expected interface present and configured?
2. **Route:** does the routing table show a plausible path?
3. **Name resolution:** does the hostname resolve to the expected address?
4. **Reachability:** does a permitted, limited connectivity check return useful evidence?
5. **Service/port:** is the expected service listening and is the connection allowed?
6. **Context:** consider firewalls, proxies, VPNs, containers, WSL2 networking, and lab restrictions.
7. **Document:** record commands, timestamps, outputs, hypotheses, and what remains unknown.

Do not jump directly to changing firewall rules, disabling security controls, or repeatedly probing a public destination.

## 9. Practical lab E — mini network investigation

**Scenario:** A fictional student application cannot connect to `lab-service.example.test`. You have permission to inspect your own machine but are not authorised to change network settings.

Run the commands that are available:

```bash
date
ip -br addr
ip route
getent hosts lab-service.example.test
ss -tuln
```

The fictional hostname may not resolve on your machine; that is expected unless your instructor has configured it. Record the result rather than substituting an unauthorised target.

| Field | Your notes |
|---|---|
| Reported symptom | |
| Time of observation | |
| Interface/address evidence | |
| Route evidence | |
| Name-resolution evidence | |
| Listening socket evidence | |
| Leading hypothesis | |
| What remains uncertain | |
| Safe next step or escalation | |

## 10. Troubleshooting and safe practice

- **`ip` is unavailable:** note the environment limitation and use other approved inspection commands that are present.
- **`getent hosts` returns nothing:** the hostname may be invalid or unavailable in configured name services, or network policy may block resolution.
- **`ping` fails:** do not conclude that the host is down; ICMP may be filtered.
- **`curl` is missing or blocked:** use the instructor-approved alternative and record the limitation.
- **`ss -tuln` is empty or short:** no visible listening sockets may exist in that environment, or visibility may be restricted.
- **No default route is shown:** this can be expected in an isolated or specially configured lab. Do not add one without authorisation.
- **WSL2 output differs from native Ubuntu:** virtual networking and host integration can change addresses, interfaces, and routes.
- **A port looks unfamiliar:** identify its purpose and owner through authorised methods; do not terminate processes or open ports based only on the number.

**Safety rule:** Only test systems you own or are authorised to assess. Avoid port scans, brute-force attempts, route changes, firewall changes, or repeated probes against public and third-party systems.

## 11. Quick command recap

| Task | Command |
|---|---|
| Hostname | `hostname` |
| IP addresses | `ip addr` |
| Brief interface view | `ip -br addr` |
| Link state | `ip link` |
| Routing table | `ip route` |
| IPv6 routes | `ip -6 route` |
| Name lookup | `getent hosts example.com` |
| Resolver status (if available) | `resolvectl status` |
| Limited ICMP check (authorised target) | `ping -c 4 HOST` |
| HTTP(S) response headers | `curl -I URL` |
| Listening sockets | `ss -tuln` |
| Neighbour cache | `ip neigh` |
| Command documentation | `man ip` |

## 12. Knowledge check — MCQs

**1. What is the main role of DNS?**

A. Assign file permissions  
B. Help map hostnames to records such as IP addresses  
C. Start Linux processes  
D. Format a filesystem

**2. Which command shows IP addresses assigned to interfaces?**

A. `ip addr`  
B. `df -h`  
C. `apt show`  
D. `ps aux`

**3. What does a routing table help the system decide?**

A. Which files to delete  
B. Where packets should be sent next  
C. Which user owns a file  
D. Which packages need updates

**4. If ping fails, what is the safest interpretation?**

A. The target is definitely powered off  
B. The target may block ICMP or the path may have a problem; more evidence is needed  
C. DNS is always broken  
D. The Linux interface must be deleted

**5. Which command commonly displays listening TCP/UDP sockets?**

A. `ss -tuln`  
B. `whoami`  
C. `du -sh`  
D. `apt policy`

**6. What is the safest approach to diagnosing a connection failure?**

A. Disable the firewall immediately  
B. Scan every reachable public host  
C. Inspect relevant layers and gather evidence before approved changes  
D. Add a default route without checking

### Answers and explanations

1. **B** — DNS provides name-resolution services.
2. **A** — `ip addr` displays interfaces and their addresses.
3. **B** — routes help choose the next hop/interface for traffic.
4. **B** — ICMP may be filtered, and other causes are possible.
5. **A** — `ss -tuln` commonly lists listening TCP and UDP sockets numerically.
6. **C** — layered diagnosis and evidence reduce unnecessary or risky changes.

## Key takeaways

- Inspect interfaces, addresses, routes, DNS, and sockets using appropriate diagnostic tools.
- Name resolution and packet routing are distinct parts of connectivity.
- A failed ping does not prove a host is down, and a successful ping does not prove an application works.
- WSL2, containers, VMs, and browser terminals can have different networking views.
- Document evidence and uncertainty before proposing a change.
- Test only systems within your authorisation and avoid disruptive network changes.

## Next chapter

**Chapter 9: Remote Access and Secure File Transfer** — learn the fundamentals of SSH, remote login, key-based authentication, and safe file transfer.

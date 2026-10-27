# Chapter 10: Network Traffic Analysis Using Wireshark

Network traffic analysis helps security and operations teams understand how systems communicate, investigate connectivity issues, and collect evidence during an incident. Wireshark presents captured packets in a searchable interface so an analyst can examine protocols, endpoints, timestamps, and selected packet details. The goal is not to label every unusual packet as malicious, but to ask a focused question, collect relevant evidence, and state what the evidence does—and does not—prove.

> **Lab safety:** Use the instructor-provided packet capture or a capture from a network you own or are explicitly authorised to inspect. Do not capture other people's traffic, bypass network controls, or inspect private communications without permission. Packet captures may contain credentials, session cookies, personal information, or confidential business data. Never upload a real capture publicly.

## Learning objectives

By the end of this chapter, you should be able to:

- Explain what a packet capture contains and identify common Wireshark panes.
- Distinguish capture filters from display filters.
- Use basic display filters to narrow DNS, TCP, HTTP, TLS, and endpoint traffic.
- Inspect packet metadata and use a conversation or stream view where appropriate.
- Record observations separately from hypotheses and conclusions.
- Handle capture files safely and explain why encrypted traffic limits what can be seen.

## 1. Industry scenario: investigate a slow application

A support team receives reports that a fictional campus portal is intermittently slow. One user says the page never loads; another reports a long delay before sign-in. The team has an instructor-approved packet capture from a controlled test session, plus application logs and timestamps.

A network analyst should not immediately conclude that the network is under attack. Delay may be related to DNS resolution, connection setup, retransmissions, server response time, a proxy, a dependency, or ordinary congestion. Wireshark helps narrow the question by showing the traffic that was captured. It does not automatically reveal the root cause.

![Wireshark analysis workflow](/images/tutorials/cybersecurity/ch10-wireshark-analysis-workflow.png)

## 2. What is a packet capture?

A packet capture is a record of network packets observed at a particular capture point and time. Common file extensions include `.pcap` and `.pcapng`. The capture point matters: a laptop capture, a server capture, and a network tap may see different traffic.

A packet typically contains some combination of:

- **Link-layer information:** such as Ethernet source and destination addresses, when present.
- **Network-layer information:** such as source and destination IP addresses.
- **Transport-layer information:** such as TCP or UDP ports and flags.
- **Application protocol details:** when the protocol is recognised and the relevant data is visible.
- **Timing and length:** useful for understanding sequence, delay, and traffic volume.

A capture is not a perfect view of everything happening on a network. Packets may be missed, offloading can affect what a host capture displays, traffic may use a different path, and encryption may hide application content.

## 3. Understand the Wireshark interface

The main packet-analysis areas are:

| Area | What it shows | Analyst question |
|---|---|---|
| Packet list | One row per captured packet, with time, source, destination, protocol, length, and summary | Which packets are relevant to my question? |
| Packet details | Expandable protocol fields for the selected packet | What fields are present in this packet? |
| Packet bytes | Raw bytes for the selected packet, when available | What bytes correspond to the selected field? |
| Display filter bar | Filters the packets shown in the current view | Can I narrow the view to a protocol or endpoint? |
| Statistics/conversations | Summaries of traffic and conversations | Which endpoints or conversations account for relevant activity? |

![Wireshark display filter guide](/images/tutorials/cybersecurity/ch10-wireshark-display-filter-guide.png)

## 4. Display filters for common questions

Display filters narrow the packets shown; they do not delete packets from the capture. Enter a filter in the display-filter bar and apply it. Field availability depends on the protocol and Wireshark version.

| Display filter | Purpose | Example question |
|---|---|---|
| `dns` | Show packets recognised as DNS | What name-resolution exchanges appear in this capture? |
| `tcp` | Show TCP packets | Are there connection setup, reset, or retransmission clues? |
| `tls` | Show TLS protocol packets | Is a TLS handshake visible? |
| `http` | Show packets recognised as HTTP | What HTTP metadata is visible in this authorised sample? |
| `ip.addr == 192.0.2.10` | Show IPv4 packets involving the example address | What captured packets involve this endpoint? |
| `tcp.port == 443` | Show TCP packets using port 443 | What traffic uses this port in the capture? |
| `dns || tcp` | Show packets matching either expression | Can I compare DNS activity with TCP traffic? |

`192.0.2.10` is an example documentation address; replace it only with an endpoint you are authorised to investigate and that appears in your supplied capture.

**Capture filter versus display filter**

- A **capture filter** decides which packets are recorded while capturing. Packets excluded by the capture filter are not available later in that file.
- A **display filter** controls which already-captured packets are shown. Removing a display filter does not change the original capture.

For the beginner lab, prefer a supplied `.pcap` or `.pcapng` file and display filters. This avoids capturing other people's traffic.

## 5. TCP, DNS, HTTP, and TLS: what can you infer?

### DNS

DNS traffic can show queries and responses, names, record types, and response codes when visible in the capture. A missing response in the file does not prove the resolver failed; the packet may not have been captured, or the exchange may have taken another path.

### TCP

TCP flags and sequence behaviour can provide clues about connection establishment, closure, resets, and retransmissions. A retransmission can occur for multiple reasons and does not, by itself, prove an attack or identify the device responsible.

### HTTP

Unencrypted HTTP may expose request paths, headers, and content. Inspect only an authorised training capture. Do not collect, copy, or publish credentials, cookies, tokens, or personal information. Many modern services use HTTPS, so the HTTP application content may not be visible.

### TLS and encrypted traffic

TLS helps protect data in transit. A capture may still reveal metadata such as endpoint addresses, ports, packet sizes, timing, and some handshake details, depending on the protocol version and configuration. Encrypted application content is not normally readable from the packet capture alone. Do not attempt to bypass encryption or access session secrets as part of this exercise.

## 6. A repeatable analysis workflow

1. **Define the question.** Example: “Does the supplied capture show DNS queries before the TCP connection?”
2. **Confirm scope.** Record the capture filename, source, time range, and permission to inspect it.
3. **Open the supplied capture.** Avoid starting a live capture on a shared or public network.
4. **Apply a narrow display filter.** Begin with `dns`, `tcp`, or another relevant protocol.
5. **Inspect a packet.** Expand the protocol fields and record timestamp, endpoints, protocol, and relevant details.
6. **Compare related packets.** Look for the request/response sequence or use the relevant conversation view.
7. **Write a cautious interpretation.** Separate direct observations from possible explanations.
8. **Recommend the next check.** Use approved logs, application metrics, or a second capture point if available.
9. **Protect the evidence.** Store the file in the approved location and redact sensitive details before sharing.

![Packet evidence worksheet](/images/tutorials/cybersecurity/ch10-packet-evidence-worksheet.png)

## 7. Practical mini-lab: analyse an instructor-provided capture

**Required:** Wireshark installed on a laptop, or an instructor-approved environment, and a supplied `.pcap`/`.pcapng` file. If students cannot install Wireshark, the instructor can demonstrate the same steps on a shared screen and distribute screenshots or a prepared evidence table.

### Task A — Establish context

1. Open the supplied capture in Wireshark.
2. Record the filename, capture time range if available, and total packet count.
3. Note the visible columns: time, source, destination, protocol, length, and info.
4. Do not assume the capture contains all traffic from the application or network.

### Task B — Ask three focused questions

Apply each display filter separately and record your observations.

| Filter | Record |
|---|---|
| `dns` | A visible query name, response if present, and timestamp |
| `tcp` | One source/destination pair and any visible TCP flags relevant to the task |
| `tls` | Whether TLS packets or handshake details are visible in the sample |

If a filter shows no packets, record “no matching packets in this capture.” Do not conclude that the protocol is never used.

### Task C — Follow one conversation

1. Select a relevant packet from the approved sample.
2. If appropriate, use the context menu to follow its TCP stream or inspect its conversation.
3. Record what is visible and what is hidden by encryption.
4. Do not copy sensitive payloads or share session identifiers.

### Task D — Write a short evidence note

Use this template:

| Field | Student entry |
|---|---|
| Question | What were you trying to find out? |
| Capture | Filename and source supplied by instructor |
| Filter | Exact display filter used |
| Observation | What the packet list/details directly showed |
| Interpretation | What the observation may mean |
| Limitation | What cannot be concluded from this capture alone |
| Next step | One safe, authorised check that could clarify the issue |

### Reflection questions

1. Why is “no matching packets” different from “the protocol is not used”?
2. Why can a retransmission not be treated as proof of an attack?
3. What can a capture reveal about an HTTPS connection even when content is encrypted?
4. Why should packet captures be handled like sensitive evidence?

## 8. Industry example: separate observation from hypothesis

| Observation | Possible hypothesis | What is still unknown? |
|---|---|---|
| A DNS query is visible, but no response appears in the supplied capture | Response was delayed, lost, filtered, or not captured | Whether the resolver received/responded to the query |
| TCP retransmissions appear | Packet loss, congestion, path issues, or other conditions may be involved | Exact cause and location of loss |
| TLS packets appear, but application content is unreadable | The connection uses encryption | Whether the application itself is secure or the user is authorised |
| A large number of packets involve one endpoint | A busy service, bulk transfer, or unusual activity may be present | Whether the traffic is malicious without more context |

These are investigation prompts, not automatic diagnoses.

## 9. Key takeaways

- Wireshark is a packet-analysis tool; it does not automatically determine root cause.
- Use supplied captures or inspect traffic only with explicit authorisation.
- Display filters narrow the visible packet list without changing the capture.
- DNS, TCP, HTTP, and TLS each provide different kinds of evidence.
- Encryption limits payload visibility; metadata alone rarely proves intent.
- Record timestamps, filters, observations, limitations, and next steps.
- Protect capture files because they may contain sensitive personal or authentication data.

## 10. Knowledge check

1. What does a Wireshark display filter do?
   - A. Permanently deletes packets from the capture
   - B. Narrows which captured packets are displayed
   - C. Decrypts every TLS connection
   - D. Proves whether a packet is malicious

2. Which filter shows packets recognised as DNS?
   - A. `dns`
   - B. `password`
   - C. `allports`
   - D. `decrypt`

3. What is the difference between a capture filter and a display filter?
   - A. They are identical
   - B. A display filter controls which packets are recorded
   - C. A capture filter controls what is recorded; a display filter controls what is shown
   - D. A capture filter decrypts traffic

4. A capture contains TCP retransmissions. What is the best conclusion?
   - A. The system is definitely under attack
   - B. Retransmissions are evidence worth investigating, but have multiple possible causes
   - C. The application is definitely secure
   - D. DNS is broken

5. Why may HTTPS application content not be readable in Wireshark?
   - A. Wireshark cannot display IP addresses
   - B. TLS encrypts application data in transit
   - C. HTTPS does not use packets
   - D. TCP filters remove the content

6. Which practice is appropriate for a student lab?
   - A. Capture classmates' traffic without asking
   - B. Upload a real capture containing cookies to a public forum
   - C. Use an instructor-provided capture and document observations carefully
   - D. Treat every unfamiliar packet as malicious

**Answer key:** 1-B, 2-A, 3-C, 4-B, 5-B, 6-C.

---

**Cybersecurity & Practices · JSPM University · B.Tech Year III**  
*Practical-first learning: capture only with permission, interpret carefully, and protect the evidence.*

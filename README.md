# PVID Generator

A lightweight WordPress plugin that generates a unique **Page View ID (PVID)** on every pageview and exposes it as `window.pvid` for collection by analytics and ad services.

## Overview

PVID is designed to serve as a primary key for re-stitching transaction-level data across multiple data services (GA4, Google Ad Manager, data warehouse pipelines, etc.). Because it is generated fresh on every pageview and shared across all services simultaneously, it can be used as a reliable join key in downstream analytics.

### How the PVID is constructed

The PVID is a concatenation of two values generated in the browser at page load time:

```
window.pvid = epoch_timestamp_seconds + random_8_digit_number
```

| Component | Example | Notes |
|---|---|---|
| Unix epoch (seconds) | `1709481600` | 10 digits |
| Random 8-digit number | `53821047` | Range: 10,000,000 – 99,999,999 |
| **PVID** | **`170948160053821047`** | 18-digit string |

The script is injected into `wp_head` with a priority of `-1000`, ensuring it runs before any other scripts on the page.
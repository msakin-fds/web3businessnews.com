# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**web3businessnews.com** — a Web3/blockchain business news website running WordPress on SiteGround shared hosting.

- **Live site:** https://web3businessnews.com
- **WP Admin:** https://web3businessnews.com/wp-admin (user: fdsthinker@fds.com)
- **Hosting:** SiteGround
- **Server path:** `/home/u6-njxvujwge0d4/www/web3businessnews.com/public_html`

## Repository Structure

This repo tracks only custom WordPress files — not the full WordPress core:

```
wp-content/
  themes/      ← custom/child theme files
  plugins/     ← custom plugin files
.github/
  workflows/
    deploy.yml ← auto-deploys to SiteGround on push to main
```

## Theme & Page Builder

- **Active theme:** Hello Elementor v3.4.7 — a minimal Elementor-optimised base theme
- **Template kit:** NeoNews (ElementsKit) — provides the news site layout and design
- **Page builder:** Elementor v4.0.1 + Elementor Pro v3.35.1
- Design changes (layouts, widgets, styling) are made in the Elementor visual editor, not directly in PHP/CSS files
- Custom CSS or PHP overrides go in a child theme under `wp-content/themes/`

## Active Plugins

| Plugin | Version | Purpose |
|--------|---------|---------|
| Elementor | 4.0.1 | Page builder core |
| Elementor Pro | 3.35.1 | Theme builder, popups, forms, pro widgets |
| Element Pack Pro | 9.1.0 | Additional Elementor widgets (BdThemes) — currently inactive |
| ElementsKit Lite | 3.9.0 | Elementor addons + NeoNews template kit |
| MetForm | 4.1.3 | Form builder for Elementor |
| PopupKit | 2.2.4 | Popup builder (Wpmet) |
| Yoast SEO | 27.3 | SEO, XML sitemaps |
| Yoast Duplicate Post | 4.6 | Clone posts/pages |
| Skyboot Custom Icons for Elementor | 1.1.0 | 14,300+ icon library |
| Envato Market | 2.0.13 | Theme/plugin updates from Envato |
| Template Kit Import | 1.0.16 | Import Envato template kits |
| Security Optimizer | 1.6.0 | SiteGround security hardening |
| Speed Optimizer | 7.7.8 | SiteGround performance/caching |
| SiteGround Central | 3.4.1 | SiteGround hosting management |
| Site Kit by Google | 1.176.0 | Google Analytics/Search Console integration |
| Quick Featured Images | 13.7.5 | Bulk featured image management — currently inactive |
| WordPress Importer | 0.9.5 | Import WXR files |

## Deployment

Every push to `main` that changes files under `wp-content/` automatically deploys to the live server via GitHub Actions (rsync over SSH).

**Required GitHub Secrets** (github.com → repo → Settings → Secrets → Actions):

| Secret | Value |
|--------|-------|
| `SSH_HOST` | `ssh.web3businessnews.com` |
| `SSH_USER` | `u6-njxvujwge0d4` |
| `SSH_PASSWORD` | *(SiteGround SSH password)* |
| `SSH_PORT` | `18765` |
| `WP_PATH` | `/home/u6-njxvujwge0d4/www/web3businessnews.com/public_html` |

## WordPress REST API

Use the Application Password for content updates (posts, pages, etc.):

- **Auth:** HTTP Basic — username `fdsthinker@fds.com` + application password from `.env`
- **Base URL:** `https://web3businessnews.com/wp-json/wp/v2/`
- **Note:** Cloudflare blocks automated requests — add a bypass rule for `/wp-json/*` to enable API access

## Database

- **Host:** `127.0.0.1` (server-local only, not externally accessible)
- **Name:** `dbfrqtzx0hsm0r`
- **Charset:** `utf8`
- Full credentials in `.env` (see `.env.example`)

## Development Branch

Active development branch: `claude/init-project-setup-gpVho`

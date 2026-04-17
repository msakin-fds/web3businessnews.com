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

## Deployment

Every push to `main` that changes files under `wp-content/` automatically deploys to the live server via GitHub Actions (rsync over SSH).

**Required GitHub Secrets** (set at github.com → repo → Settings → Secrets → Actions):

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
- **Note:** Cloudflare may block automated requests — add a bypass rule for `/wp-json/*` if needed

## Database

- **Host:** `127.0.0.1` (server-local only, not externally accessible)
- **Charset:** `utf8mb4`
- Credentials stored in `.env` (see `.env.example`)

## Development Branch

Active development branch: `claude/init-project-setup-gpVho`

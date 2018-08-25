# Imageboard Content Observer

[![Build status](https://api.travis-ci.org/desu-project/imageboard-content-observer.svg)](https://travis-ci.org/desu-project/imageboard-content-observer)
[![Violinist enabled](https://img.shields.io/badge/violinist-enabled-brightgreen.svg?maxAge=604800)](https://violinist.io)

This project is a part of Desu Engine ecosystem.

This service monitors imageboards such as Danbooru, Konachan and others and pushes all posts to private Telegram channels with inline keyboard buttons. By pressing these buttons, moderator sorts imageboards' content for future use by Desu Engine runners.

## Supported imageboards

* [Danbooru](https://danbooru.donmai.us) via [desu-project/danbooru-sdk](https://github.com/desu-project/danbooru-sdk)

## How to setup

In order to start observing imageboards' content, you should prepare few things.

### Create Telegram bot

You should talk with [@BotFather](https://t.me/BotFather) - it's official Telegram bot, which allows Telegram users to create new bots. After successful creation bot token will be returned. It should be saved in `TELEGRAM_BOT_API_KEY` environment variable.

### Add bot to all channels

Your bot should be added to all your channels as admin with permission to post messages.

### Add channel IDs to environment variables

If you created channel for posts from Danbooru and added bot there, you should save channel's ID in `DANBOORU_TELEGRAM_CHAT_ID` environment variable. Same for all other imageboards.

It's possible to set single channel for all imageboards. Just specify one channel ID for all `{imageboard}_TELEGRAM_CHAT_ID` environment variables.

Note that channel username and channel ID are different things. If you don't know your channel ID, use [@get_id_bot](https://t.me/get_id_bot) bot.

### Insert your imageboard credentials

Imageboard Content Observer uses Danbooru's and other's APIs to extract their content. 

#### [Danbooru](https://danbooru.donmai.us)

1. Register and login in Danbooru.
2. Click "My Account", then click "View" link near "API Key".
3. Copy API key and insert in in `DANBOORU_API_KEY` variable as `{your_danbooru_username}:{api_key}`. Example: `DANBOORU_API_KEY=nookie:WhwCmHx3TxsuBWWEXchqWTqOZ6BqLe4qdo9FfLBcSAR`.

### Register Telegram webhook

There is command to do so:

````bash
bin/console app:set-telegram-webhook example.com
````

Where `example.com` is your domain. You should specify domain name without scheme like `https://` or so.

Note that webhook requires SSL configured on your server, so your domain should be accessible via HTTPS.

## License

Imageboard Content Observer is licensed under MIT license. For further details see [LICENSE](LICENSE) file.

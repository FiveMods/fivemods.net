## FiveMods Developer Documentation

### Index

1. Status API
2. 

### Status API

To request the status of either FiveMods or FiveM services, you need to have an API token.
If you don't have one [click here][1] to generate one.

Once you have your API token you can request the status by following these steps:

1. Make your request

    For your request you need to set the Authorization header to `Bearer [API-TOKEN]`

    You also need to set the following get request options:
    ```
    if you want the fivemods status:
    fivemods=true

    if you want the fivem status:
    fivem=true
    ```

2. Send your request

    Send the request to <https://fivemods.net/pages/status/api/callback.php>.

3. Recieve the output

    You will now recieve an output, the output will look something like this:
    ```json
    {"main":0,"updown":0,"discord":0,"google":0,"github":0,"advertisement":0,"cookies":0,"location":0,"payment":0,"serverlist":0,"auth":0,"ingame":0,"website":0,"artifacts":0,"keymaster":5}
    ```

    The numbers represent a status, please use the following guide to decode them:
    - 0 = Operational
    - 1 = Degraded Performance
    - 2 = Partial Outage
    - 3 = Major Outage
    - 4 = Maintenance
    - 5 = Security Mode (Cloudflare)

[1]: https://fivemods.net/account/
# Run MaNGOS Web V4 in Docker
## Install

There few cases of running website in container:

- **Development:** website with database service — for development or browsing. 
  1. **Default:** With empty game server database initialization.  
     Designed to make website just working.
  2. **Custom:** Without empty game server database initialization (set `SETUP_SKIP=1` in `.env.mysql`)  
     Designed to make website working with existing game server databases.
     Website database will be placed in container service.
- **Production:** only website container without database container.

### Development environment setup

1. Create environment variables
   ```sh
   cp .env.mw.dist .env.mw
   cp .env.mysql.dist .env.mysql
   ``` 
2. Adjust these files according to your environment.  
   **Note:** On first container run it will retrieve databases dump files from
   [github.com/celguar/spp-classics-cmangos](https://github.com/celguar/spp-classics-cmangos/blob/master/Server/Sql/vanilla/)
   remote repository the only SQL files to create empty game server databases.
   To avoid this behaviour set `SETUP_SKIP=1` in `.env.mysql` file before running `docker compose` command.
3. Run 
   ```sh
   docker compose -f compose.dev.yaml up
   ```

After application is started, website should be available at: http://127.0.0.1/

## Maintenance

If it's required to remove all data, execute next commands:

```sh
## WARNING: THIS WILL REMOVE ALL DATA!
docker container rm mangos-website-mw-1 mangos-website-mysql-1
docker volume rm mangos-website_data_mysql mangos-website_setup_mysql
```

It could be useful if it's required to install project from scratch,
don't forget to rename `./install/` and `./update` directories back.

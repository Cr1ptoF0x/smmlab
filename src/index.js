import { Container, getContainer } from "@cloudflare/containers";
import { env } from "cloudflare:workers";

export class SMMLabContainer extends Container {
  defaultPort = 80;
  sleepAfter = "10m";
  envVars = {
    APP_NAME: env.APP_NAME ?? "FollowBooster Store",
    APP_ENV: env.APP_ENV ?? "production",
    APP_DEBUG: env.APP_DEBUG ?? "false",
    APP_KEY: env.APP_KEY,
    APP_URL: env.APP_URL,
    DB_CONNECTION: "mysql",
    DB_HOST: env.DB_HOST,
    DB_PORT: env.DB_PORT ?? "3306",
    DB_DATABASE: env.DB_DATABASE,
    DB_USERNAME: env.DB_USERNAME,
    DB_PASSWORD: env.DB_PASSWORD,
    SESSION_DRIVER: env.SESSION_DRIVER ?? "database",
    CACHE_STORE: env.CACHE_STORE ?? "database",
    QUEUE_CONNECTION: env.QUEUE_CONNECTION ?? "database",
    FILESYSTEM_DISK: env.FILESYSTEM_DISK ?? "local",
  };
}

export default {
  async fetch(request, env) {
    const url = new URL(request.url);
    if (url.pathname === "/_health") {
      return new Response("ok", {
        headers: { "content-type": "text/plain; charset=utf-8" },
      });
    }
    const app = getContainer(env.SMMLAB_CONTAINER, "smmlab-production");
    return app.fetch(request);
  },
};

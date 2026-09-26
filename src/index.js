import { Container, getContainer } from "@cloudflare/containers";

export class SMMLabContainer extends Container {
  defaultPort = 80;
  sleepAfter = "10m";
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

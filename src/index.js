import { Container, getContainer } from "@cloudflare/containers";

export class SMMLabContainer extends Container {
  defaultPort = 80;
  sleepAfter = "10m";
}

export default {
  async fetch(request, env) {
    const app = getContainer(env.SMMLAB_CONTAINER, "smmlab-production");
    return app.fetch(request);
  }
};

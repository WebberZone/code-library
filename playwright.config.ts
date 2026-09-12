import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: 'tests/e2e',
  timeout: 30000,
  use: { baseURL: 'http://127.0.0.1:4321/code-library' },
  webServer: { command: 'pnpm run preview --host 127.0.0.1', url: 'http://127.0.0.1:4321/code-library/', reuseExistingServer: true },
  projects: [{ name: 'chromium', use: devices['Desktop Chrome'] }],
});

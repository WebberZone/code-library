import { expect, test } from '@playwright/test';

test('snippet tags open the browser with the matching tag selected', async ({ page }) => {
  await page.goto('/code-library/snippets/contextual-related-posts/crp-api-example/');
  await page.getByRole('link', { name: 'templates', exact: true }).click();

  await expect(page).toHaveURL(/\/code-library\/snippets\/\?tag=templates$/);
  await expect(page.locator('select[name="tag"]')).toHaveValue('templates');
  await expect(page.getByRole('link', { name: 'Build a trending-posts template' })).toBeVisible();
  await expect(page.getByRole('link', { name: 'Add categories to related posts' })).toHaveCount(0);
});

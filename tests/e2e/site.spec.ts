import { expect, test } from '@playwright/test';

test('home page lists plugins and navigates from search', async ({ page }) => {
  await page.goto('/code-library/');
  await expect(page.getByRole('heading', { name: 'Practical plugin customizations, ready to inspect.' })).toBeVisible();
  await expect(page.getByRole('link', { name: 'Better Search' }).first()).toBeVisible();
  const search = page.getByRole('combobox', { name: 'Search the code library' });
  await search.fill('footnotes');
  await expect(page.getByRole('option', { name: /Index Easy Footnotes content/ })).toBeVisible();
  await page.keyboard.press('Enter');
  await expect(page).toHaveURL(/bsearch-easy-footnotes-integration\/$/);
  await expect(page.getByRole('link', { name: 'Download plugin ZIP' })).toBeVisible();
});

test('snippet browser filters client-side', async ({ page }) => {
  await page.goto('/code-library/snippets/');
  await page.getByRole('searchbox', { name: 'Search' }).fill('footnotes');
  await expect(page.getByText('1 of 22 snippets')).toBeVisible();
  await expect(page.getByRole('link', { name: 'Index Easy Footnotes content' })).toBeVisible();
});

test('gated snippets stay visible without download controls', async ({ page }) => {
  await page.goto('/code-library/snippets/better-search/better-search-tags/');
  await expect(page.getByText('Needs review before use.')).toBeVisible();
  await expect(page.getByRole('button', { name: 'Copy PHP' })).toHaveCount(0);
  await expect(page.getByRole('link', { name: 'Download PHP' })).toHaveCount(0);
  await expect(page.getByRole('link', { name: 'Download plugin ZIP' })).toHaveCount(0);
});

test('mobile navigation exposes the main links', async ({ page }) => {
  await page.setViewportSize({ width: 390, height: 800 });
  await page.goto('/code-library/');
  await page.getByLabel('Open navigation').click();
  await expect(page.getByRole('link', { name: 'Install snippets', exact: true })).toBeVisible();
  await expect(page.getByRole('link', { name: 'Contribute', exact: true })).toBeVisible();
});

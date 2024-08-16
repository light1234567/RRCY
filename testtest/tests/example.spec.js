import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/login');
  await page.getByLabel('Email').click();
  await page.getByRole('link', { name: 'Don\'t have an account yet?' }).click();
  await page.getByLabel('Name').click();
  await page.getByLabel('Name').fill('haripath');
  await page.getByLabel('Name').press('Enter');
  await page.getByLabel('Email').fill('haripath@gmail.com');
  await page.getByLabel('Email').press('Tab');
  await page.getByLabel('Password', { exact: true }).fill('123123123123');
  await page.getByLabel('Password', { exact: true }).press('Tab');
  await page.getByLabel('Confirm Password').fill('123123123123');
  await page.getByLabel('Role').selectOption('social services');
  await page.getByRole('button', { name: 'Register' }).click();
});
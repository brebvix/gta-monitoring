import { MaterialAngularcliPage } from './app.po';

describe('material-angularcli App', () => {
  let page: MaterialAngularcliPage;

  beforeEach(() => {
    page = new MaterialAngularcliPage();
  });

  it('should display welcome message', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('Welcome to app!!');
  });
});

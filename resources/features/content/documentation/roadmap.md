This is roadmap for development, all planned features will be listed here. You can add an issue here to ask for new feature [**bookshelves-add issue**](https://gitlab.com/ewilan-riviere/bookshelves-back/-/issues).

## *Ideas*

### Back-end

- [ ] i18n for back features
- [ ] Improve libre ebooks meta with Calibre
- [ ] Add attribute on each method for Controller
- [ ] Add explanation form each part of EpubParser
- [ ] larastan upgrade level
- [ ] more tests for models

---

## *Planned*

### Back-end

- [ ] Rewrite eBook parser engine
- [ ] Datatables
- [ ] API doc
  - [ ] responseField
  - [ ] Binding routes
- [ ] Logs for EpubParser
- [ ] Authors notes
- [ ] toc for Features with CommonMark
- [ ] MJML for Catalog
  - <https://github.com/asahasrabuddhe/laravel-mjml>
- [ ] Build browser eReader with Webreader
  - <https://stackoverflow.com/questions/49330858/display-dynamic-html-content-like-an-epub-ebook-without-converting-html-to-epub>

### Front-end

- [ ] `nuxt bridge`
- [ ] improve jsonld, sitelinks
- [ ] markdown image
- [ ] Cookie consent
  - <https://www.webrankinfo.com/dossiers/droit-internet/consentement-cookies>
  - <https://www.cnil.fr/fr/cookies-et-traceurs-que-dit-la-loi>
  - <https://www.freeprivacypolicy.com/free-cookies-policy-generator/>
  - <https://www.osano.com/cookieconsent/download/>
  - <https://brainsum.github.io/cookieconsent/>
  - <https://github.com/osano/cookieconsent>
  - <https://tarteaucitron.io/en/>
  - <https://debbie.codes/blog/nuxt-cookie-consent/>
  - <https://github.com/EvodiaAut/vue-cookieconsent-component>
  - <https://gitlab.com/broj42/nuxt-cookie-control>

---

## *In progress*

### Back-end

- [ ] Improve OPDS

### Front-end

- [ ] `script setup` migration
- [ ] add i18n
- [ ] review each component, remove import
- [ ] admin for front
  - [ ] selection books
  - [ ] update no ebooks entities
- [ ] Improve search
- [ ] Improve advanced search

---

## *Done*

- [x] Meilisearch to replace native search if needed (native can be used without Meilisearch)

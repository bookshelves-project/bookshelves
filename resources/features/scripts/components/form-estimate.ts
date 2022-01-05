import axios from 'axios'

const formEstimate = (residence: any = null) =>
  ({
    activeFormStep: residence ? 'PersonsForm' : 'ResidenceForm',
    submitting: false,
    get steps() {
      const steps: any[] = []

      if (residence === null) {
        steps.push({
          number: 1,
          title: 'Votre résidence',
          startForm: 'ResidenceForm',
        })
      }

      return [
        ...steps,
        ...[
          {
            number: 2,
            title: 'Nombre de personnes',
            startForm: 'PersonsForm',
          },
          {
            number: 3,
            title: 'Vos coordonnées',
            startForm: 'ProfileForm',
          },
          {
            number: 4,
            title: 'Votre devis',
            startForm: 'Result1Form',
          },
        ],
      ]
    },
    formSteps: [
      {
        step: 1,
        number: 1,
        title: 'Votre résidence',
        type: 'ResidenceForm',
        isValid: (form) => form.id_mdm !== null,
      },
      {
        step: 2,
        number: 2,
        title: 'Nombre de personnes',
        type: 'PersonsForm',
        isValid: (form) => form.persons !== 0,
      },
      {
        step: 3,
        number: 3,
        title: 'Vos coordonnées',
        type: 'ProfileForm',
        isValid: (form) => {
          return ![
            'gender',
            'first_name',
            'last_name',
            'phone',
            'email',
            'prospect_status',
          ].some((v) => form[v] === '')
        },
      },
      {
        step: 4,
        number: 4,
        title: 'Votre devis',
        type: 'Result1Form',
        isValid: () => true,
        isSubmit: () => true,
      },
      {
        step: 4,
        number: 5,
        title: 'Surface de votre appartement',
        type: 'RoomsForm',
        isValid: (form) => form.rooms !== 0,
      },
      {
        step: 4,
        number: 6,
        title: 'Votre devis affiné',
        type: 'Result2Form',
        isValid: () => true,
        isSubmit: () => true,
      },
    ],
    genders: ['M.', 'Mme'],
    prospect_status: {
      senior: 'Senior',
      close: 'Proche de senior',
      child: 'Enfant de senior',
    },
    residence: null,
    form: {
      id_mdm: residence?.id_mdm,
      persons: 0,
      rooms: 1,
      gender: '',
      first_name: '',
      last_name: '',
      phone: '',
      email: '',
      prospect_status: '',
      optin: false,
    },
    results: {
      residence_name: null,
      residence_url: null,
      residence_city: null,
      price: 0,
      persons: 0,
      rooms: 0,
      url: null,
    },
    errors: null,
    init() {
      if (residence) {
        this.residence = {
          id_mdm: residence.id_mdm,
          name: residence.name,
          price: residence.call_price || 0,
        }
      }

      window.dataLayer.push({
        event: 'checkout',
        eventCategory: 'Ecommerce',
        eventAction: 'Entrée checkout',
        eventLabel: window.settings.leadID,
      })
    },
    get finished() {
      return this.results !== null
    },
    get currentFormStep() {
      return this.formSteps.find((f) => f.type === this.activeFormStep)
    },
    get nextFormStep() {
      const estimateForm = document.getElementById('estimate')

      window.scrollTo({
        top: estimateForm ? estimateForm.offsetTop - 200 : 0,
        behavior: 'smooth',
      })

      const index = this.formSteps.findIndex(
        (f) => f.type === this.activeFormStep
      )

      return this.formSteps[index + 1]
    },
    get currentStep() {
      return this.steps.find((f) => f.number === this.currentFormStep?.step)
    },
    get disableSubmit() {
      return !this.currentFormStep.isValid(this.form) || this.submitting
    },
    isDone(step: { number: number; title: string }) {
      return step.number < this.currentStep?.number
    },
    isCurrent(step: { number: number; title: string }) {
      return step.number === this.currentStep?.number
    },
    async next() {
      if (!this.currentFormStep.isValid(this.form) || !this.nextFormStep) {
        return
      }

      if (this.nextFormStep.isSubmit) {
        if (!(await this.submit())) {
          return
        }
      }

      this.goTo(this.nextFormStep.type)
    },
    goTo(type: string) {
      const eventLabels = {
        ResidenceForm: 'Choix résidence',
        PersonsForm: 'Choix nombre de personnes',
        ProfileForm: `${this.form.persons} Pièces`,
        Result1Form: 'Devis',
        RoomsForm: 'Choix nombre de pièces',
        Result2Form: `${this.form.rooms} Pièces`,
      }

      window.dataLayer.push({
        event: 'virtualPageview',
        eventCategory: 'Formulaires',
        eventAction: `Devis - ${this.currentFormStep.number} - ${this.currentFormStep.title}`,
        eventLabel: eventLabels[this.currentFormStep.type],
      })

      this.activeFormStep = type
      this.errors = null

      window.dataLayer.push({
        ecommerce: {
          checkout: {
            actionField: { step: this.currentFormStep.step },
            products: this.residence
              ? [
                  {
                    name: this.residence.name,
                    id: this.residence.id_mdm,
                    price: parseInt(this.residence.price || 0, 10),
                    brand: null,
                    category: null,
                    variant: 'Residence Domitys Senior',
                    quantity: 1,
                  },
                ]
              : [],
          },
        },
        event: 'checkout',
      })
    },
    actionUrl() {
      return (this.$refs.form as HTMLElement).getAttribute('action')
    },
    selectResidence(residence: any) {
      this.residence = residence
      this.form.id_mdm = residence.id_mdm

      this.next()
    },
    selectPersons(persons: number) {
      this.form.persons = persons

      // Par défault un dévis sur un T1 seul sera proposé, même en cas d'un couple
      this.form.rooms = 1
      this.next()
    },
    selectRooms(rooms: number) {
      this.form.rooms = rooms
      this.next()
    },
    async submit() {
      this.errors = null
      this.submitting = true

      try {
        const { data } = await axios.post(this.actionUrl(), this.form)
        this.results = data
      } catch (e) {
        if (axios.isAxiosError(e) && e.response) {
          this.errors = e.response.data
          return
        }

        this.errors = {
          message:
            'Erreur lors de la soumission du formulaire, veuillez réessayer',
        }

        return false
      } finally {
        this.submitting = false
      }

      window.dataLayer.push({
        ecommerce: {
          purchase: {
            actionField: {
              id: window.settings.leadID,
              affiliation: 'Online Store',
              revenue: this.results.price,
              tax: 0,
              shipping: null,
              coupon: null,
            },
            products: [
              {
                name: this.residence.name,
                id: this.residence.id_mdm,
                price: this.results.price,
                brand: null,
                category: null,
                variant: 'Residence Domitys Senior',
                quantity: 1,
              },
            ],
          },
        },
        event: 'purchase',
      })

      return true
    },
  } as any)

export default formEstimate

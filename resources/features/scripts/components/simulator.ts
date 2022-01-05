import axios from 'axios'

const simulator = (residence: any = null) =>
  ({
    activeFormStep: 'GoalForm',
    submitting: false,
    showTaxInfo: false,
    steps: [
      {
        number: 1,
        title: 'Mes objectifs',
        startForm: 'GoalForm',
      },
      {
        number: 2,
        title: 'Mon financement',
        startForm: 'PaymentMethodForm',
      },
      {
        number: 3,
        title: "Ma tranche marginale d'imposition",
        startForm: 'TaxForm',
      },
      {
        number: 4,
        title: 'Mon profil',
        startForm: 'ProfileForm',
      },
    ],
    formSteps: [
      {
        type: 'GoalForm',
        step: 1,
        title: 'Quel est votre objectif ?',
        isValid: (form) => form.goal !== null,
        nextForm: () => 'PaymentMethodForm',
      },
      {
        type: 'PaymentMethodForm',
        step: 2,
        title: 'Comment souhaitez-vous financer votre projet ?',
        isValid: (form) => form.payment_method !== null,
        prevForm: () => 'GoalForm',
        nextForm: (data: any) =>
          data.payment_method === 'cash' ? 'CashForm' : 'CreditForm',
        eventLabels: 'Choix financement',
      },
      {
        type: 'CashForm',
        step: 2,
        title: 'Quel capital souhaitez-vous investir ?',
        isValid: () => true,
        prevForm: () => 'GoalForm',
        nextForm: () => 'TaxForm',
      },
      {
        type: 'CreditForm',
        step: 2,
        title: 'Paramétrez votre crédit',
        isValid: () => true,
        prevForm: () => 'GoalForm',
        nextForm: () => 'TaxForm',
      },
      {
        type: 'TaxForm',
        step: 3,
        title: "Quelle est votre tranche marginale d'imposition ?",
        isValid: (form) => form.tax_bracket !== null,
        prevForm: () => 'PaymentMethodForm',
        nextForm: () => 'ProfileForm',
        eventLabels: 'Imposition',
      },
      {
        type: 'ProfileForm',
        step: 4,
        title: 'Votre profil',
        isValid: (form) => {
          return ![
            'gender',
            'first_name',
            'last_name',
            'phone',
            'email',
            'postal_code',
            'city',
          ].some((v) => form[v] === '')
        },
        prevForm: () => 'TaxForm',
        eventLabels: 'Profil',
      },
    ],
    goals: window.settings.goals,
    payment_methods: window.settings.payment_methods,
    tax_brackets: [0, 11, 30, 41, 45],
    genders: ['Mr', 'Mme'],
    residence: null,
    form: {
      goal: null,
      payment_method: null,
      capital: 90000,
      contribution: 0,
      monthly_payment: 300,
      loan_duration: 15,
      tax_bracket: 30,
      gender: '',
      first_name: '',
      last_name: '',
      phone: '',
      email: '',
      postal_code: '',
      city: '',
      optin: false,
    },
    results: null as {
      taxes_reduction: number
      assets_development: number
      monthly_income: number
      additional_income: number
    } | null,
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
    get currentStep() {
      return this.steps.find((f) => f.number === this.currentFormStep?.step)
    },
    isDone(step: { number: number; title: string }) {
      return step.number < this.currentStep?.number
    },
    isCurrent(step: { number: number; title: string }) {
      return step.number === this.currentStep?.number
    },
    get canPrev() {
      return this.currentFormStep.step !== 1
    },
    get canNext() {
      return this.currentFormStep.isValid(this.form) && !this.submitting
    },
    prev() {
      this.goTo(this.currentFormStep.prevForm())
    },
    next() {
      window.scrollTo({
        top:
          window.scrollY +
          (this.$el as HTMLElement).getBoundingClientRect().top -
          100,
        behavior: 'smooth',
      })

      if (!this.currentFormStep.isValid(this.form)) {
        return
      }

      if (this.currentFormStep.nextForm === undefined) {
        return this.submit()
      }

      this.goTo(this.currentFormStep.nextForm(this.form))
    },
    goTo(type: string) {
      window.dataLayer.push({
        event: 'virtualPageview',
        eventCategory: 'Formulaires',
        eventAction: `Simulateur - ${this.currentFormStep.step} - ${this.currentFormStep.title}`,
        eventLabel: window.settings.goals[this.form.goal],
      })

      this.activeFormStep = type

      if (this.currentFormStep.eventLabels) {
        window.dataLayer.push({
          event: 'uaform',
          eventCategory: 'Simulateur',
          eventAction: 'Etapes Simulateur',
          eventLabel: this.currentFormStep.eventLabels,
        })
      }

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
                    variant: 'Programme Domitys Invest',
                    quantity: 1,
                  },
                ]
              : [],
          },
        },
        event: 'checkout',
      })
    },
    get actionUrl() {
      return (this.$refs.form as HTMLElement).getAttribute('action')
    },
    async submit() {
      window.dataLayer.push({
        event: 'uaform',
        eventCategory: 'Simulateur',
        eventAction: 'Etapes Simulateur',
        eventLabel: 'Résultats',
      })

      this.errors = null
      this.submitting = true

      try {
        const { data } = await axios.post(this.actionUrl, this.form)
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
      } finally {
        this.submitting = false
      }

      window.dataLayer.push({
        ecommerce: {
          purchase: {
            actionField: {
              id: window.settings.leadID,
              affiliation: 'Online Store',
              revenue: 0,
              tax: 0,
              shipping: null,
              coupon: null,
            },
            products: this.residence
              ? [
                  {
                    name: this.residence.name,
                    id: this.residence.id_mdm,
                    price: parseInt(this.residence.price || 0, 10),
                    brand: null,
                    category: null,
                    variant: 'Programme Domitys Invest',
                    quantity: 1,
                  },
                ]
              : [],
          },
        },
        event: 'purchase',
      })
    },
  } as any)

export default simulator

const slider = (
  value: number,
  min: number,
  max: number,
  step: number,
  format
) =>
  ({
    value,
    min,
    max,
    step,
    format,
    get steps() {
      let i = this.min
      const steps: number[] = []

      do {
        steps.push(i)
        i += this.step
      } while (i <= this.max)

      return steps
    },
    get position() {
      return (this.steps.indexOf(this.value) / (this.steps.length - 1)) * 100
    },
    init() {
      const moveStep = (e: MouseEvent) => {
        const rect = (this.$refs.slider as HTMLElement).getBoundingClientRect()
        const slideLength = rect.right - rect.left
        const cursorPosition = e.clientX - rect.left

        const relativeCursorPosition = cursorPosition / slideLength

        const nearestStepIndex = Math.round(
          (this.steps.length - 1) * relativeCursorPosition
        )

        if (nearestStepIndex >= 0 && nearestStepIndex < this.steps.length) {
          this.value = this.steps[nearestStepIndex]
          this.$dispatch('change', this.value)
        }
      }

      let isMoving = false

      this.$refs.cursor.addEventListener('pointerdown', (e) => {
        isMoving = true
        e.preventDefault()
      })
      window.addEventListener('pointermove', (e: MouseEvent) => {
        if (isMoving) {
          moveStep(e)
        }
      })
      this.$refs.slider.addEventListener('touchmove', (e: TouchEvent) => {
        if (isMoving) {
          e.preventDefault()
        }
      })
      window.addEventListener('pointerup', () => {
        isMoving = false
      })

      this.$refs.slider.addEventListener('click', (e: MouseEvent) =>
        moveStep(e)
      )
    },
  } as any)

export default slider

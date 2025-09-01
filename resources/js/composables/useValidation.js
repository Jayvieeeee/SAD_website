import { ref } from 'vue'

export function useValidation(rules) {
  const errors = ref({})

  function validate(form) {
    const newErrors = {}
    let firstInvalidField = null

    for (const field in rules) {
      for (const rule of rules[field]) {
        const result = rule(form[field])
        if (result !== true) {
          newErrors[field] = result
          if (!firstInvalidField) {
            firstInvalidField = field
          }
          break
        }
      }
    }

    errors.value = newErrors

    // scroll to first error field
    if (firstInvalidField) {
      const el = document.querySelector(`[name="${firstInvalidField}"]`)
      if (el) {
        el.scrollIntoView({ behavior: "smooth", block: "center" })
        el.focus()
      }
    }

    return Object.keys(newErrors).length === 0
  }

  return { errors, validate }
}

const fadeInterval = 10


const fadeIn = async (el, transitionHeight) => {
    let opacity = 0.1
    el.style.opacity = "0"
    let height = el.offsetHeight
    const referenceHeight = el.offsetHeight
    if (transitionHeight) {
        el.style.overflow = "hidden"
        el.style.height = "auto"
    }
    const timer = setInterval(() => {
        if (opacity >= 0.9) {
            clearInterval(timer)
            el.style.opacity = "1"
            el.style.filter = `alpha(opacity=100)`
        }
        el.style.opacity = `${opacity}`
        el.style.filter = `alpha(opacity=${(opacity) * 100})`
        opacity += opacity * 0.1
        if (transitionHeight) {
            if (height > 15) {
                height -= height * 0.1
            } else {
                height -= 5
            }
            el.style.maxHeight = `${referenceHeight - height}px`
        }
    }, fadeInterval)
}

const fadeOut = async (el, transitionHeight) => {
    let opacity = 1
    let height = el.offsetHeight
    if (transitionHeight) {
        el.style.overflow = "hidden"
        el.style.height = "auto"
    }
    const timer = setInterval(() => {
        if (opacity <= 0.1) {
            clearInterval(timer)
            el.remove()
        }
        el.style.opacity = `${opacity}`
        el.style.filter = `alpha(opacity=${opacity * 100})`
        opacity -= opacity * 0.1
        if (transitionHeight) {
            if (height > 15) {
                height -= height * 0.1
            } else {
                height -= 5
            }
            el.style.maxHeight = `${height}px`

        }
    }, fadeInterval)
}


const createElement = (elementName, text, classList, id, children, attributes) => {
    const element = document.createElement(elementName)
    classList.forEach(className => element.classList.add(className))
    if (text) element.innerHTML = text
    if (id) element.id = id
    if (attributes) attributes.forEach(attribute => element.setAttribute(attribute.name, attribute.value))
    if (children) children.forEach(child => {
        if (child !== null) element.appendChild(child)
    })
    return element
}
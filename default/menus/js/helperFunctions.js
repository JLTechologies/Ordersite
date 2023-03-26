

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
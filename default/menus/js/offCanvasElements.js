
const createCategoryTab = (category) => {
    const linkTag = createElement("a", category.name,
        ["list-group-item", "list-group-item-action"], category.name)

    linkTag.onclick = () => clickCategory(linkTag, category.id)
    return linkTag
}

const clickCategory = (el, id) => {
    categories.forEach(({name}) => {
        const element = document.getElementById(name)
        element.classList.remove("active")
        element.ariaCurrent = false
    })
    el.classList.add("active")
    el.ariaCurrent = true
    document.getElementById("closeOffcanvas").click()
    renderProductOverview(id)
}
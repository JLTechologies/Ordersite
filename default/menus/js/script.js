const controlStructure = () => {
    categories.forEach(category => {
        const categoryEl = createCategoryTab(category)
        document.getElementById("categoryField").appendChild(categoryEl)
    })
    renderHomePage()
}

const renderHomePage = () => {
    const container = document.getElementById("productOverview")
    if (!document.getElementById("homePageField")) {
        container.innerHTML = ""
        container.appendChild(createElement("div", null, ["container"], "homepageField",
            [
                createElement("div", null, ["d-flex", "justify-content-end", "align-items-baseline",
                    "p-0"], null, [
                    createElement("p", "bekijk de menu", ["text-muted", "fs-6"]),
                    createElement("i", null, ["ms-2", "text-muted", "fas", "fa-long-arrow-alt-up"])
                ]),
                createElement("h1", "Welkom op de cocktail avond van Tjok Hove",
                    ["mb-3", "display-6", "text-center"]),
                createElement("img", null, ["object-cover", "w-100", "h-auto"],
                    null, null, [
                        {name: "src", value: "bannerEvent.jpg"},
                        {name: "alt", value: "Banner event"}
                    ])
            ]))

        categories.forEach(({name}) => {
            const element = document.getElementById(name)
            element.classList.remove("active")
            element.ariaCurrent = false
        })
    }
}

controlStructure()
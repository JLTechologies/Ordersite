const controlStructure = () => {
    categories.forEach(category => {
        const categoryEl = createCategoryTab(category)
        document.getElementById("categoryField").appendChild(categoryEl)
    })
    renderHomePage()
}

const renderHomePage = () => {
    const container = document.getElementById("productOverview")
    const completedOrder = JSON.parse(localStorage.getItem("completedOrder")) || {}

    categories.forEach(({name}) => {
        const element = document.getElementById(name)
        element.classList.remove("active")
        element.ariaCurrent = false
    })

    if (!document.getElementById("homePageField")) {
        container.innerHTML = ""
        if (completedOrder?.products) {
            const productOverview = createElement("div", null, ["container", "mt-3"], "homepageField", [
                createElement("h1", "Jouw geplaatste bestelling:", ["display-6"]),
                renderCompletedOrderOverview(completedOrder),
                createTotal(completedOrder),
                renderPaymentMethod(completedOrder),
                renderTableIndicator(completedOrder),
                renderRemoveButton(),
                renderModal()
            ])

            container.appendChild(productOverview)
            return
        }
        container.appendChild(createElement("div", null, ["container"], "homepageField",
            [
                createElement("h1", "Welkom bij het Vrolijk Toneel Initiatief!",
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

const renderCompletedOrderOverview = (completedOrder) => {
    let list = []
    completedOrder.products.forEach(obj => {
        const product = obj.product
        const liEl = createProductField(product, obj.amount, false)
        list = [...list, liEl]
    })
    return createElement("div", null, ["list-group", "col-12"], null,
        list)
}

const renderPaymentMethod = (targetOrder) => {
    return createElement("p", `Betaalmethode: ${targetOrder.betaling}`, ["lead"])
}

const renderRemoveButton = () => {
    return createElement("div", null, ["d-flex", "justify-content-end", "mt-5"], null,
        [
            createElement("button", "Bestelling niet meer tonen", ["btn", "btn-danger"], null, null,
                [
                    {name: "data-bs-target", value: "#removeModal"}, {name: "data-bs-toggle", value: "modal"}
                ])
        ])
}

const renderModal = () => {
    const confirmButton = createElement("button", "verwijderen", ["btn", "btn-danger"], null, null,
        [{name:"type", value:"button"}, {name:"data-bs-dismiss", value: "modal"}])
    confirmButton.onclick = () => {
        localStorage.removeItem("completedOrder")
        renderHomePage()
    }
    return createElement("div", null, ["modal", "fade"], "removeModal", [
        createElement("div", null, ["modal-dialog", "modal-dialog-centered"], null, [
            createElement("div", null, ["modal-content"], null, [
                createElement("div", null, ["modal-header"], "modalHeader", [
                    createElement("h5", "Bestelling niet meer tonen", ["modal-title"]),
                    createElement("button", null, ["btn-close"], null, null, [
                        {name: "type", value: "button"}, {name: "data-bs-dismiss", value: "modal"},
                        {name: "aria-label", value: "close"}
                    ])
                ]),
                createElement("div", null, ["modal-body"], null, [
                    createElement("p", "Bent u zeker dat u de bestelling niet meer wilt tonen?", ["lead", 'fw-bold']),
                    createElement("p", "Dit is permanent en kan niet ongedaan gemaakt worden. <br> " +
                        "De bestelling zal niet meer bij u getoond worden, maar deze blijft wel opgeslagen in ons systeem.", ["lead", "text-muted", "fs-6"])
                ]),
                createElement("div", null, ["modal-footer"], null, [
                    createElement("button", "Annuleren", ["btn", "btn-secondary"], null,null,
                        [{name:"type", value:"button"}, {name:"data-bs-dismiss", value:"modal"}]),
                    confirmButton
                ])
            ])
        ])
    ], [{name: "tabIndex", value: -1}, {name: "aria-hidden", value: true}, {
        name: "aria-labelledby",
        value: "modalHeader"
    }])
}

const renderTableIndicator = (targetOrder) => {
    return createElement("p", `tafel: tafel ${tables.find(table => Number(table.id) === Number(targetOrder.tableid)).number }`,
        ["lead"])
}

controlStructure()
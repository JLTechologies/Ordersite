const updateCart = () => {
    const icon = document.getElementById("cartIcon")
    if (document.getElementById("orderLength")) icon.removeChild(document.getElementById("orderLength"))
    if (order.products) {
        icon.appendChild(createElement("span", order.products.length,
            ["position-absolute", "top-0", "start-100", "translate-middle", "badge",
                "rounded-pill", "bg-primary"], "orderLength"))
    }
}

const renderOrderOverview = (bypass) => {
    const container = document.getElementById("productOverview")
    categories.forEach(({name}) => {
        const element = document.getElementById(name)
        element.classList.remove("active")
        element.ariaCurrent = false
    })
    if (bypass || !document.getElementById("orderOverview")) {
        container.innerHTML = ""
        if (order?.products?.length > 0) {
            const orderContainer = createElement("div", null, ["container"], "orderOverview")

            const orderList = renderProductField(true)
            const orderListGroup = createElement("div", null, ["list-group", "col-12"], null,
                orderList)
            if (order.products)
                orderContainer.appendChild(createElement("h1", "bestelling:", ["display-6"]))

            orderContainer.appendChild(orderListGroup)
            container.appendChild(orderContainer)
            container.appendChild(createTotal(order))
            container.appendChild(createPaymentMethod())
            container.appendChild(createTableOverview())
            container.appendChild(finishOrder())
            return
        }
        container.appendChild(createElement("h1", "Je bestelling is leeg", ["display-6"]))
    }
}

const renderProductField = (hasOnclick) => {
    let list = []
    if (!order.products) {
        list = [createElement("h1", "nog geen bestelling geplaatst", ["display-6", "text-center", "mt-3"])]
        return list
    }
    order.products.forEach(obj => {
        const product = obj.product

        const liEl = createProductField(product, obj.amount, hasOnclick)

        list = [...list, liEl]
    })

    return list
}

const createProductField = (product, amount, hasOnclick) => {

    let children = []

    if (hasOnclick) {
        children = [
            createElement("div", null, ["d-flex", "justify-content-between", "align-items-baseline", "flex-nowrap"], null, [
                createElement("p", `${amount}x ${product.name}`, ["lead", "fw-normal", "me-5", "my-0"]),
                createElement("div", null, ["d-flex", "justify-content-end", "flex-nowrap", "align-items-baseline"], null, [
                    createElement("p", `€${Number(product.price * amount).toFixed(2)}`, ["lead", "ms-5", "my-0", "fs-6"]),
                    createElement("i", null, ["fas", 'fa-chevron-down', "ms-2", "rotate", "rotate-0"], `chevron-${product.name}`)
                ])
            ])
        ]
    } else {
        children = [
            createElement("div", null, ["d-flex", "justify-content-between", "align-items-baseline", "flex-nowrap"], null, [
                createElement("p", `${amount}x ${product.name}`, ["lead", "fw-normal", "me-5", "my-0"]),
                createElement("p", `€${Number(product.price * amount).toFixed(2)}`, ["lead", "ms-5", "my-0", "fs-6"])
            ])
        ]
    }

    const liEl = document.createElement("li")
    liEl.classList.add("list-group-item")
    liEl.id = `list-element-${product.name}`
    const container = createElement("div", null,
        ["py-3"],
        `orderView-${product.name}`, children)
    if (hasOnclick) {
        container.onclick = () => {
            const chevrons = document.querySelectorAll("[id^=chevron-]")
            chevrons.forEach((chevron) => {
                chevron.classList.replace("rotate-180", "rotate-0")
            })
            if (document.getElementById(`order-${product.name}`)) {
                fadeOut(document.getElementById(`order-${product.name}`), true)
                return
            }
            document.getElementById(`chevron-${product.name}`).classList.replace("rotate-0", "rotate-180")
            const amountList = document.querySelectorAll('[id^=order-]')
            amountList.forEach(el => fadeOut(el, true))
            const subField = createProductSubField(product)
            liEl.appendChild(subField)
            fadeIn(subField, true)
        }
    }
    liEl.appendChild(container)

    return liEl
}

const createProductSubField = (product) => {
    const container = createElement("div", null, ["container", "mt-2"], `order-${product.name}`)
    container.appendChild(createAmountFieldOrder(product))
    container.appendChild(createRemoveButton(product))
    return container
}

const createRemoveButton = (product) => {
    const div = createElement("div", null, ["container", "d-flex", "justify-content-end", "mt-3", "px-2"])
    const button = createElement("button", "verwijderen", ["btn", "btn-danger"])
    button.addEventListener("click", () => removeProduct(product))
    div.appendChild(button)
    return div
}

const removeProduct = (product) => {
    order.products = [...order.products.filter(obj => obj.product.id !== product.id)]
    localStorage.setItem("order", JSON.stringify(order))
    updateCart()
    const productField = document.getElementById(`list-element-${product.name}`)
    fadeOut(productField, true).then(
        () => renderEmptyOrder()
    )
    updatePrice()
}

const createAmountFieldOrder = (product) => {

    const amountContainer = document.createElement("div")
    amountContainer.classList.add("d-flex", "justify-content-end", "align-items-center", "flex-nowrap")

    const minusButton = createElement("button", null, ["btn", "btn-light", "bg-transparent", "p-1"], null,
        [createElement("i", null, ["fas", "fa-minus"])])
    minusButton.onclick = () => reduceAmountOrder(`amount-${product.name}`, product)
    amountContainer.appendChild(minusButton)

    const amountEl = createElement("input", null, ["form-control", "mx-3", "w-25", "text-center"],
        `amount-${product.name}`, null,
        [{name: "type", value: "number"}])
    amountEl.value = order?.products?.find(obj => obj.product.id === product.id)?.amount || 1
    amountEl.addEventListener("input", (e) => onChangeAmount(e.target.value, product))
    amountContainer.appendChild(amountEl)

    const plusButton = createElement("button", null, ["btn", "btn-light", "bg-transparent", "p-1"], null,
        [createElement("i", null, ["fas", "fa-plus"])])
    plusButton.onclick = () => increaseAmountOrder(`amount-${product.name}`, product)
    amountContainer.appendChild(plusButton)

    return amountContainer
}

const onChangeAmount = (value, product) => {
    const amount = Number(value)
    if (order?.products?.find(obj => obj.product.id === product.id)) {
        const orderProduct = order.products.find(obj => obj.product.id === product.id)
        amount < 1 ? order.amount = 1 : orderProduct.amount = amount
        order.products = [...order.products.filter(obj => obj.product.id !== product.id), orderProduct]
        localStorage.setItem("order", JSON.stringify(order))
        updateOverviewField(product, amount)
    }

}


const reduceAmountOrder = (id, product) => {
    const el = document.getElementById(id)
    const amount = Number(el.value)
    reduceAmount(id, product.id, true)
    if (amount > 1) {
        updateOverviewField(product, amount - 1)
    }
}


const increaseAmountOrder = (id, product) => {
    const el = document.getElementById(id)
    const amount = Number(el.value)
    increaseAmount(id, product.id, true)
    updateOverviewField(product, amount + 1)
}


const updateOverviewField = (product, amount) => {
    const el = document.getElementById(`orderView-${product.name}`)
    el.innerHTML = ""
    const children = [
        createElement("div", null, ["d-flex", "justify-content-between", "align-items-baseline", "flex-nowrap"], null, [
            createElement("p", `${amount}x ${product.name}`, ["lead", "fw-normal", "me-5", "my-0"]),
            createElement("div", null, ["d-flex", "justify-content-end", "flex-nowrap", "align-items-baseline"], null, [
                createElement("p", `€${Number(product.price * amount).toFixed(2)}`, ["lead", "ms-5", "my-0", "fs-6"]),
                createElement("i", null, ["fas", 'fa-chevron-down', "ms-2", "rotate", "rotate-180"], `chevron-${product.name}`)
            ])
        ])
    ]

    children.forEach(child => el.appendChild(child))
    updatePrice()
}


const updatePrice = () => {
    const price = document.getElementById("totalPrice")
    price.innerHTML = ""

    let totalPrice = 0
    order.products.forEach(obj => totalPrice += (obj.product.price * obj.amount))

    price.appendChild(createElement("p", "totaal", ["lead"]))
    price.appendChild(createElement("p", `€${totalPrice.toFixed(2)}`, ["lead"], ["totaal"]))

}

const renderEmptyOrder = () => {
    if (order.products.length < 1) {
        const overview = document.getElementById("orderOverview")
        overview.innerHTML = ""
        Promise.all(
            [fadeOut(document.getElementById("totalPrice")),
                fadeOut(document.getElementById("paymentContainer")),
                fadeOut(document.getElementById("tableContainer")),
                fadeOut(document.getElementById("submitButton"))]
        ).then(() => {
                const headerText = createElement("h1", "Je bestelling is leeg", ["display-6"])
                headerText.style.opacity = '0'
                overview.appendChild(headerText)
                fadeIn(headerText)
            }
        )

    }
}

const createTotal = (targetOrder) => {
    let totalPrice = 0
    targetOrder.products.forEach(obj => totalPrice += (obj.product.price * obj.amount))
    return createElement("div", null, ["container", "d-flex", "justify-content-between", "p-3"], "totalPrice", [
        createElement("p", "totaal", ["lead"]),
        createElement("p", `€${totalPrice.toFixed(2)}`, ["lead"], ["totaal"])
    ])
}

const createPaymentMethod = () => {
    const cashSelected = order.betaling === "Cash" || false
    const payconiqSelected = order.betaling === "Payconiq" || false
    const cashInput = createElement("input", null, ["form-check-input"], "paymentCash", null,
        [{name: "type", value: "radio"}, {name: "name", value: "payment"}])
    cashInput.onclick = () => setPayment("Cash")
    if (cashSelected) cashInput.checked = true
    const payconiqInput = createElement("input", null, ["form-check-input"], "paymentPayconiq", null,
        [{name: "type", value: "radio"}, {name: "name", value: "payment"}])
    payconiqInput.onclick = () => setPayment("Payconiq")
    if (payconiqSelected) payconiqInput.checked = true
    return createElement("div", null, ["container", "mx-auto", "d-flex", "flex-column", "mt-3"],
        "paymentContainer",
        [
            createElement("h1", "Betalingswijze", ["display-6"]),
            createElement("div", null, ["form-check"], null, [
                cashInput,
                createElement("label", "Cash", ["form-check-label"], null, null,
                    [{name: "for", value: "paymentCash"}])
            ]),
            createElement("div", null, ["form-check"], null, [
                payconiqInput,
                createElement("label", "Payconiq", ["form-check-label"], null, null,
                    [{name: "for", value: "paymentPayconiq"}])
            ])
        ])
}

const setPayment = (value) => {
    order.betaling = value
    localStorage.setItem("order", JSON.stringify(order))
}

const createTableOverview = () => {

    let tableEllist = null;

    if (order.tableid) {
        tableEllist = [createElement("option", "selecteer je tafel", ["lead"], null, null,
            [{name: "value", value: null}])]
    } else {
        tableEllist = [createElement("option", "selecteer je tafel", ["lead"], null, null,
            [{name: "selected", value: true}, {name: "value", value: null}])]
    }
    tables.forEach((table) => {
        order.tableid && Number(order.tableid) === table.id ?
            tableEllist = [...tableEllist, createElement("option", `tafel ${table.number}`, ["lead"],
                null, null, [{name: "selected", value: true}, {name: "value", value: table.id}])] :
            tableEllist = [...tableEllist, createElement("option", `tafel ${table.number}`, ["lead"],
                null, null, [{name: "value", value: table.id}])]
    })

    const select = createElement("select", null, ["form-select", "my-3"], "tableContainer", tableEllist)
    select.addEventListener("change", (e) => {
        order.tableid = e.target.value
        localStorage.setItem("order", JSON.stringify(order))
    })

    return select
}

const finishOrder = () => {
    const button = createElement("button", "bestelling afronden", ["btn", "btn-primary"])
    button.onclick = () => processOrder()
    return createElement("div", null, ["container", "d-flex", "justify-content-end", "my-3"], "submitButton", [button])
}


updateCart()
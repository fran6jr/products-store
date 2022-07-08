import React, { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import './styles.scss'
import useProductList from "../../hooks/useProductList"
import { useDelete } from "hooks/useDelete"
import { Selected } from "hooks/types"

const Home = () => {

  const [ selected, setSelected ] = useState<Selected[]>([]);
  const { products, refetch } = useProductList();
  const { error, loading, deleteProducts } = useDelete();

  useEffect(() => {
    if (loading === false && !error) {
      refetch()
      setSelected([]);
    }
  }, [loading, error, refetch])

  const onSelect = (sku: string) => {
    const prev = [...selected]
    const index = selected.findIndex(s => s.sku === sku)

    if (index === -1) {
      setSelected([...prev, { sku, type: products.find(p => p.sku === sku)?.type as any}])
    } else {
      prev.splice(index, 1)
      setSelected([...prev])
    }
  }

  const onMassDelete = async () => {
    if (selected.length)
      deleteProducts(selected);
  }

  return (
    <div className="home">
      <div className="header">
        <h1>Product List</h1>
        <div>
          <Link to='addproduct'>
            <button>ADD</button>
          </Link>
          <button
            id='#delete-product-btn'
            className="delete_button"
            onClick={onMassDelete}
          >
            MASS DELETE
          </button>
        </div>
      </div>

      <div className="list_container">
        {products.map(product => {
          const { sku, name, price, weight, size, width, height, length } = product
          
          const priceStr = price? price.toFixed(2) : "N/A"
          return (
            <div
              key={sku}
              className="card"
            >
              <input
                type='checkbox'
                name='stuff'
                className="delete-checkbox"
                onChange={() => onSelect(sku)}
                checked={selected.some(s => s.sku === sku)}
              />
              <p>{sku.toUpperCase()}</p>
              <p>{name}</p>
              <p>{priceStr} $</p>
              {size && <p>{size.toFixed(2)} MB</p>}
              {weight && <p>{weight.toFixed(2)} KG</p>}
              {width && <p>Dimension: {`
                ${height}x${width}x${length}`
              }</p>}
            </div>
          )
        })}
      </div>
      <h5 className="footer">Scandiweb Test assignment</h5>
    </div>
  )
}

export default Home

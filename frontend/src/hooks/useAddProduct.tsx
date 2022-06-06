import { useState } from "react";
import { Product } from "./types"


const baseUrl = process.env.REACT_APP_BASEURL


const useAddProduct = () => {
  const [error, setError] = useState(
    {
      state: false,
      message: ""
    }
  );

  const [loading, setLoading] = useState<boolean>();

  const addProduct = async (product: Product) => {
    setError({
      state: false,
      message: ""
    });
    setLoading(true);
    try {
      const response = await fetch(baseUrl + "/add",
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(product)
        }
      )
      await response?.json();
    }
    catch (e) {
      console.log(JSON.stringify(e));
      setError({ 
        state: true,
        message: "Product could not be added. Please try again or check if product exists"
      });
    }

    setLoading(false);

  }

  return { error, loading, addProduct };

}

export default useAddProduct;

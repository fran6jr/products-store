import React, { Suspense } from 'react';
import {
  BrowserRouter,
  Routes,
  Route,
} from "react-router-dom"

const Home = React.lazy(() => import('./pages/Home/Home'));
const Add = React.lazy(() => import('./pages/Add/Add'));

const App = () => {
  return (
    <BrowserRouter>
      <Suspense>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="addproduct" element={<Add />} />
        </Routes>
      </Suspense>
    </BrowserRouter>
  )
}

export default App;

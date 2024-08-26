<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Event Connect API</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #F2E4DC;
            height: 100vh;
        }

        #canvasPlace {
            height: 80%;
            /* border: 2px red solid; */
        }

        #canvas {
            height: 100%;
            width: 100%;
            /* filter: invert(); */
        }

        h1 {
            color: #63281A;
        }

        #links {
            display: flex;
            margin-top: 2em;
        }

        .link {
            background-color: #F35733;
            margin: 2em;
            padding: 1em;
            border-radius: 15px;
            text-decoration: none;
            color: white;
            transition: all .2s ease-in-out;
        }

        .link:hover {
            transform: scale(1.1);
        }
    </style>

    <!-- Import Three.js -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>

    <!-- Import OrbitControl -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/controls/OrbitControls.js"></script>

    <!-- Import GLTFLoader -->
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/examples/js/loaders/GLTFLoader.js"></script>

</head>

<body id="body">
    <h1>Bienvenue sur l'API EventConnect</h1>

    <section id="links">
        <a class="link" href="#">Documentation</a>
        <a class="link" href="#">Admin</a>
    </section>

    <div id="canvasPlace">
        <canvas id="canvas"></canvas>
    </div>

    <script>
        window.onload = () => {
            const canvasPlace = document.getElementById('canvasPlace');
            const canvas = document.getElementById('canvas');

            if (canvas && canvasPlace) {
                canvas.width = canvasPlace.clientWidth;
                canvas.height = canvasPlace.clientHeight;

                const scene = new THREE.Scene();
                const camera = new THREE.PerspectiveCamera(70, canvas.clientWidth / canvas.clientHeight, 0.1, 1000);
                camera.position.set(0, 0, 3.5);

                const renderer = new THREE.WebGLRenderer({
                    canvas,
                    alpha: true
                });
                renderer.setSize(canvas.clientWidth, canvas.clientHeight);
                renderer.setClearColor(0x000000, 0);

                // Create OrbitControls instance
                const controls = new THREE.OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true;
                controls.dampingFactor = 0.5;
                controls.enableZoom = true;

                // Create GLTFLoader instance
                const loader = new THREE.GLTFLoader();

                let logoModel = null;
                let titleModel = null;

                loader.load('/logo/logoFini.glb', function(gltf) {
                    logoModel = gltf.scene;
                    scene.add(logoModel);
                }, undefined, function(error) {
                    console.error(error);
                });

                loader.load('/logo/titre.glb', function(gltf) {
                    titleModel = gltf.scene;
                    scene.add(titleModel);

                    titleModel.rotation.y = 4.75;
                    titleModel.position.set(0, -0.2, 1.3);
                    titleModel.scale.set(0.45, 0.45, 0.45);
                }, undefined, function(error) {
                    console.error(error);
                });

                function animate() {
                    requestAnimationFrame(animate);
                    renderer.setSize(canvas.clientWidth, canvas.clientHeight);

                    if (logoModel) {
                        logoModel.rotation.y += 0.01;
                    }

                    controls.update();
                    renderer.render(scene, camera);
                }
                animate();
            } else {
                console.error("Canvas or CanvasPlace element not found");
            }
        }
    </script>

</body>

</html>
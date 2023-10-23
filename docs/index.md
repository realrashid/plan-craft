---
layout: home
title: PlanCraft
titleTemplate: Elevate Your Plans Management with PlanCraft for Laravel

hero:
  name: "PlanCraft"
  text: "Elevate Your Plans Management with PlanCraft for Laravel"
  tagline: Transforming Laravel Plans Management. Break free from conventional database storage constraints.
  image:
    src: /logo-large.svg
    alt: PlanCraft
  actions:
    - theme: brand
      text: Get Started
      link: /guide/introduction
    - theme: alt
      text: View On Github
      link: https://github.com/realrashid/plan-craft

features:
  - icon: "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><defs><linearGradient id='grad1' x1='0%' y1='0%' x2='100%' y2='100%'><stop offset='0%' style='stop-color:#FF9966;stop-opacity:1' /><stop offset='100%' style='stop-color:#FF5E62;stop-opacity:1' /></linearGradient></defs><path fill='url(#grad1)' d='M21 12c1.1046 0 2-.8954 2-2s-.8954-2-2-2h-7V2c0-1.1046-.8954-2-2-2s-2 .8954-2 2v6H2c-1.1046 0-2 .8954-2 2s.8954 2 2 2h6v6c0 1.1046.8954 2 2 2s2-.8954 2-2v-6h7zm0-2H7V2c0-1.1046.8954-2 2-2s2 .8954 2 2v8z'/></svg>"
    title: Plan Management
    details: Define and manage various subscription plans.
  - icon: "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><defs><linearGradient id='grad2' x1='0%' y1='0%' x2='100%' y2='100%'><stop offset='0%' style='stop-color:#33CCFF;stop-opacity:1' /><stop offset='100%' style='stop-color:#FF3366;stop-opacity:1' /></linearGradient></defs><path fill='url(#grad2)' d='M12 0C5.383 0 0 5.383 0 12s5.383 12 12 12 12-5.383 12-12S18.617 0 12 0zm0 21c-5.238 0-9.5-4.262-9.5-9.5S6.762 2 12 2s9.5 4.262 9.5 9.5-4.262 9.5-9.5 9.5zm1.707-11.707 4 4c.195.195.293.451.293.707s-.098.512-.293.707c-.39.39-1.024.39-1.414 0l-3.293-3.293V14c0 .553-.447 1-1 1s-1-.447-1-1V9.707L6.707 11.707c-.195.195-.451.293-.707.293s-.512-.098-.707-.293c-.39-.39-.39-1.024 0-1.414l4-4c.39-.39 1.024-.39 1.414 0z'/></svg>"
    title: Feature Control
    details: Seamlessly create, manage, and assign features to plans with ease.
  - icon: "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><defs><linearGradient id='grad3' x1='0%' y1='0%' x2='100%' y2='100%'><stop offset='0%' style='stop-color:#FFD700;stop-opacity:1' /><stop offset='100%' style='stop-color:#FF6347;stop-opacity:1' /></linearGradient></defs><path fill='url(#grad3)' d='M12 2C6.487 2 2 6.487 2 12s4.487 10 10 10 10-4.487 10-12S17.513 2 12 2zm0 18c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8zm1-10h-2c-.553 0-1 .447-1 1s.447 1 1 1h2c.553 0 1-.447 1-1s-.447-1-1-1zm0 4H11c-.553 0-1 .447-1 1s.447 1 1 1h2c.553 0 1-.447 1-1s-.447-1-1-1z'/></svg>"
    title: Eligibility Checks
    details: Perform sophisticated eligibility checks for specific features based on subscription levels
  - icon: "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><defs><linearGradient id='grad4' x1='0%' y1='0%' x2='100%' y2='100%'><stop offset='0%' style='stop-color:#FF9966;stop-opacity:1' /><stop offset='100%' style='stop-color:#FF5E62;stop-opacity:1' /></linearGradient></defs><path fill='url(#grad4)' d='M20 0H4C1.794 0 0 1.794 0 4v16c0 2.206 1.794 4 4 4h16c2.206 0 4-1.794 4-4V4c0-2.206-1.794-4-4-4zm2 20c0 1.1046-.8954 2-2 2H4c-1.1046 0-2-.8954-2-2V4c0-1.1046.8954-2 2-2h16c1.1046 0 2 .8954 2 2v16zM12 14.5c0-.2761.2239-.5.5-.5s.5.2239.5.5v2.5h2c.2761 0 .5.2239.5.5s-.2239.5-.5.5h-2v2.5c0 .2761-.2239.5-.5.5s-.5-.2239-.5-.5V18h-2c-.2761 0-.5-.2239-.5-.5s.2239-.5.5-.5h2v-2.5z'/></svg>"
    title: Database-Less Plans
    details: Define plans directly in the PlanCraftServiceProvider, eliminating the need for database storage.

---

<style>
:root {
  --vp-home-hero-name-color: transparent;
  --vp-home-hero-name-background: -webkit-linear-gradient(120deg, #4338ca 30%, #312e81);

  --vp-home-hero-image-background-image: linear-gradient(-45deg, #4338ca 50%, #312e81 50%);
  --vp-home-hero-image-filter: blur(40px);
}

.main .text::after {
  content: " ";
  display: inline-block;
  height: 5px;
  width: 45%;
  background-image: repeating-linear-gradient(45deg, #4338ca, #4338ca 10px, #312e81 10px, #312e81 20px); /* Wavy pattern */
}

.VPLink.no-icon.VPFeature {
  transition: transform 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
}

.VPLink.no-icon.VPFeature:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  color: #fff;
  background-image: -webkit-linear-gradient(120deg, #4338ca 30%, #312e81 50%);
}

.VPLink.no-icon.VPFeature:hover .icon {
  background-color: #fff;
}

.VPLink.no-icon.VPFeature:hover .details {
  color: #fff;
}

@media (min-width: 640px) {
  :root {
    --vp-home-hero-image-filter: blur(56px);
  }
}

@media (min-width: 960px) {
  :root {
    --vp-home-hero-image-filter: blur(72px);
  }
}
</style>


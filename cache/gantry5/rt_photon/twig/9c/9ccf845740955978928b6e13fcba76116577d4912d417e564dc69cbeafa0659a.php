<?php

/* @particles/atomo-animatecss-wowjs.html.twig */
class __TwigTemplate_df9c645f0e2209c52b7d35e9a424b1705f3a35b52fb0431e8eb85c8e18c5b168 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/atomo-animatecss-wowjs.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
            'javascript_footer' => array($this, 'block_javascript_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_particle($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $assetFunction = $this->env->getFunction('parse_assets')->getCallable();
        $assetVariables = array();
        if ($assetVariables && !is_array($assetVariables)) {
            throw new UnexpectedValueException('{% scripts with x %}: x is not an array');
        }
        $location = "head";
        if ($location && !is_string($location)) {
            throw new UnexpectedValueException('{% scripts in x %}: x is not a string');
        }
        $priority = isset($assetVariables['priority']) ? $assetVariables['priority'] : 0;
        ob_start();
        // line 5
        echo "        ";
        if ($this->getAttribute(($context["particle"] ?? null), "enabled", array())) {
            // line 6
            echo "        \t";
            if ($this->getAttribute(($context["particle"] ?? null), "enabled_animatecss", array())) {
                // line 7
                echo "         <link rel=\"stylesheet\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://css/animate.min.css"), "html", null, true);
                echo "\" type=\"text/css\"/>
        \t";
            }
            // line 9
            echo "        ";
        }
        // line 10
        echo "    ";
        $content = ob_get_clean();
        $assetFunction($content, $location, $priority);
    }

    // line 14
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 15
        echo "\t";
        if ($this->getAttribute(($context["particle"] ?? null), "enabled", array())) {
            // line 16
            echo "\t  ";
            if ($this->getAttribute(($context["particle"] ?? null), "enabled_wowjs", array())) {
                // line 17
                echo "\t\t";
                $this->displayParentBlock("javascript_footer", $context, $blocks);
                echo "
\t\t<script src=\"";
                // line 18
                echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/wow.min.js"), "html", null, true);
                echo "\" type=\"text/javascript\"></script>
\t\t<script type=\"text/javascript\">
\t\t\twow = new WOW({
\t\t\tmobile: ";
                // line 21
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "mobile", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "mobile", array()), "false")) : ("false")));
                echo ",
\t\t\toffset: ";
                // line 22
                echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "offset", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "offset", array()), "200")) : ("200")));
                echo " });
\t\t\twow.init();
\t\t</script>
\t  ";
            }
            // line 26
            echo "\t";
        }
    }

    public function getTemplateName()
    {
        return "@particles/atomo-animatecss-wowjs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 26,  90 => 22,  86 => 21,  80 => 18,  75 => 17,  72 => 16,  69 => 15,  66 => 14,  60 => 10,  57 => 9,  51 => 7,  48 => 6,  45 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/atomo-animatecss-wowjs.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\custom\\particles\\atomo-animatecss-wowjs.html.twig");
    }
}

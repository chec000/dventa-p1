<?php

/* @particles/gridstatistic.html.twig */
class __TwigTemplate_ac57e6aeb2749d19179d23c5b950ed17492fc06c80a2617edb1f289e7223c601 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/gridstatistic.html.twig", 1);
        $this->blocks = array(
            'javascript' => array($this, 'block_javascript'),
            'particle' => array($this, 'block_particle'),
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
    public function block_javascript($context, array $blocks = array())
    {
        // line 4
        $this->getAttribute(($context["gantry"] ?? null), "load", array(0 => "mootools"), "method");
        // line 5
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/odometer.js"), "html", null, true);
        echo "\"></script>
<script>
;((function(){

var isElementInViewport = function(el, delta) {
    var rect = el.getBoundingClientRect();
    delta = delta || 0;
    return (
        rect.top >= -delta &&
        rect.left >= -delta &&
        rect.bottom <= (delta + (window.innerHeight || document.documentElement.clientHeight)) &&
        rect.right <= (delta + (window.innerWidth || document.documentElement.clientWidth))
    );
}

window.addEvents({
    scroll: function(){
        var odometers = document.getElements('.odometer'), value, instances = {};
        odometers.forEach(function(odometer, idx){
            odometer = document.id(odometer);
            if (!instances['o-' + idx] && isElementInViewport(odometer, 100)) {
                value = odometer.getProperty('data-odometer-value');
                instances['o-' + idx] = { i: new Odometer({el: odometer}), v: value };
                setTimeout(function(){
                    instances['o-' + idx].i.update(instances['o-' + idx].v || 0);
                }, 100);
            }
        });
    },
    domready: function(){
        this.fireEvent('scroll');
    }
});

})());
</script>
";
    }

    // line 43
    public function block_particle($context, array $blocks = array())
    {
        // line 44
        echo "  
<div class=\"";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
        echo "\">
\t";
        // line 46
        if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
            echo "<h2 class=\"g-title\">";
            echo $this->getAttribute(($context["particle"] ?? null), "title", array());
            echo "</h2>";
        }
        echo "\t

\t<div class=\"g-gridstatistic\">
\t\t";
        // line 49
        if ($this->getAttribute(($context["particle"] ?? null), "desc", array())) {
            echo "<div class=\"g-gridstatistic-desc\">";
            echo $this->getAttribute(($context["particle"] ?? null), "desc", array());
            echo "</div>";
        }
        // line 50
        echo "\t\t";
        if ($this->getAttribute(($context["particle"] ?? null), "readmore", array())) {
            echo "<a href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "readmorelink", array()));
            echo "\" class=\"button ";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "readmoreclass", array()));
            echo "\">";
            echo $this->getAttribute(($context["particle"] ?? null), "readmore", array());
            echo "</a>";
        }
        echo "\t
\t\t
\t\t<div class=\"g-gridstatistic-wrapper ";
        // line 52
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "cols", array()));
        echo "\">
\t\t\t";
        // line 53
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "gridstatisticitems", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["gridstatisticitem"]) {
            // line 54
            echo "\t\t\t    <div class=\"g-gridstatistic-item\">
\t\t\t    \t<div class=\"g-gridstatistic-item-wrapper\">
                <div class=\"g-gridstatistic-item-icon\"><span class=\"";
            // line 56
            echo twig_escape_filter($this->env, $this->getAttribute($context["gridstatisticitem"], "icon", array()));
            echo "\"></span></div> 
\t\t\t        \t<div class=\"g-gridstatistic-item-text1 odometer\" data-odometer-value=\"";
            // line 57
            echo twig_escape_filter($this->env, $this->getAttribute($context["gridstatisticitem"], "text1", array()));
            echo "\"></div>
\t\t\t        \t<div class=\"g-gridstatistic-item-text2\">";
            // line 58
            echo twig_escape_filter($this->env, $this->getAttribute($context["gridstatisticitem"], "text2", array()));
            echo "</div>\t\t
\t\t\t    \t</div>
\t\t\t    </div>\t
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gridstatisticitem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        echo " 
\t\t</div>

\t</div>\t


</div>
";
    }

    public function getTemplateName()
    {
        return "@particles/gridstatistic.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  146 => 61,  136 => 58,  132 => 57,  128 => 56,  124 => 54,  120 => 53,  116 => 52,  102 => 50,  96 => 49,  86 => 46,  82 => 45,  79 => 44,  76 => 43,  34 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/gridstatistic.html.twig", "/var/www/html/templates/rt_photon/custom/particles/gridstatistic.html.twig");
    }
}

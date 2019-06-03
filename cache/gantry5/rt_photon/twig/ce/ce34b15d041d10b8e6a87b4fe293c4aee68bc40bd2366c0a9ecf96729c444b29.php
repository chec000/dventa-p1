<?php

/* @particles/contenttabs.html.twig */
class __TwigTemplate_716ddf02da34307a88a7bfceac2a46ee278edd208ed039c67a159752b3f25069 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/contenttabs.html.twig", 1);
        $this->blocks = array(
            'javascript' => array($this, 'block_javascript'),
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
    public function block_javascript($context, array $blocks = array())
    {
        // line 4
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/juitabs.js"), "html", null, true);
        echo "\"></script>
";
    }

    // line 7
    public function block_particle($context, array $blocks = array())
    {
        // line 8
        echo "<div class=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
        echo "\">
  ";
        // line 9
        if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
            echo "<h2 class=\"g-title\">";
            echo $this->getAttribute(($context["particle"] ?? null), "title", array());
            echo "</h2>";
        }
        // line 10
        echo "
  <div class=\"g-contenttabs\">
    <div id=\"g-contenttabs-";
        // line 12
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\" class=\"g-contenttabs-container\">
      <ul class=\"g-contenttabs-tab-wrapper-container\">
        ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 15
            echo "        <li class=\"g-contenttabs-tab-wrapper\">
          <span class=\"g-contenttabs-tab-wrapper-head\">
            <a class=\"g-contenttabs-tab\" href=\"#";
            // line 17
            echo twig_escape_filter($this->env, twig_replace_filter(twig_escape_filter($this->env, $this->getAttribute($context["item"], "tabname", array())), array(" " => "")), "html", null, true);
            echo "\">
              <span class=\"g-contenttabs-tab-title\">";
            // line 18
            echo $this->getAttribute($context["item"], "title", array());
            echo "</span>
              <span class=\"g-contenttabs-tab-subtitle\">";
            // line 19
            echo $this->getAttribute($context["item"], "subtitle", array());
            echo "</span>
            </a>
          </span>
        </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "      </ul>

      <div class=\"clearfix\"></div>

      <ul class=\"g-contenttabs-content-wrapper-container\">
        ";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 30
            echo "        <li class=\"g-contenttabs-tab-wrapper\">
          <div class=\"g-contenttabs-tab-wrapper-body\">
            <div id=\"";
            // line 32
            echo twig_escape_filter($this->env, twig_replace_filter(twig_escape_filter($this->env, $this->getAttribute($context["item"], "tabname", array())), array(" " => "")), "html", null, true);
            echo "\" class=\"g-contenttabs-content\">
              ";
            // line 33
            if ($this->getAttribute($context["item"], "desc", array())) {
                // line 34
                echo "              ";
                echo $this->getAttribute($context["item"], "desc", array());
                echo "
              ";
            }
            // line 36
            echo "              ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["item"], "tags", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
                // line 37
                echo "              <div class=\"g-contenttabs-tag\">
                <div class=\"g-contenttabs-content-tag\">
                  <span class=\"g-contenttabs-content-tag-text\">";
                // line 39
                echo $this->getAttribute($context["tag"], "tag", array());
                echo "</span>
                  <span class=\"g-contenttabs-content-subtag-dot g-contenttabs-content-subtag-dot-";
                // line 40
                echo twig_escape_filter($this->env, (($this->getAttribute($context["tag"], "subtagdotaccent", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["tag"], "subtagdotaccent", array()), "accent1")) : ("accent1")), "html", null, true);
                echo "\" ";
                if ($this->getAttribute($context["tag"], "subtagdotcustom", array())) {
                    echo "style=\"background-color: ";
                    echo $this->getAttribute($context["tag"], "subtagdotcustom", array());
                    echo "\"";
                }
                echo " ></span>
                  <span class=\"g-contenttabs-content-subtag-text\">";
                // line 41
                echo $this->getAttribute($context["tag"], "subtagtext", array());
                echo "</span>
                </div>
                <div class=\"g-contenttabs-content-text\">
                  <span>";
                // line 44
                echo $this->getAttribute($context["tag"], "subtagdesc", array());
                echo "</span>
                </div>
              </div>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 48
            echo "            </div>
          </div>
        </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        echo "      </ul>

      <div class=\"clearfix\"></div>

    </div>
  </div>

</div>

";
    }

    // line 63
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 64
        echo "<script type=\"text/javascript\">
jQuery(window).load(function(){
  jQuery('#g-contenttabs-";
        // line 66
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "').tabs({
    show: {
      ";
        // line 68
        if ((((($this->getAttribute(($context["particle"] ?? null), "animation", array()) == "up") || ($this->getAttribute(($context["particle"] ?? null), "animation", array()) == "down")) || ($this->getAttribute(($context["particle"] ?? null), "animation", array()) == "left")) || ($this->getAttribute(($context["particle"] ?? null), "animation", array()) == "right"))) {
            // line 69
            echo "      effect: 'slide',
      direction: '";
            // line 70
            echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "animation", array()), "html", null, true);
            echo "',
      ";
        } else {
            // line 72
            echo "      effect: '";
            echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "animation", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "animation", array()), "slide")) : ("slide")), "html", null, true);
            echo "',
      ";
        }
        // line 74
        echo "      duration: ";
        echo twig_escape_filter($this->env, (($this->getAttribute(($context["particle"] ?? null), "duration", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute(($context["particle"] ?? null), "duration", array()), "500")) : ("500")), "html", null, true);
        echo "
    }
  });
});
</script>
";
    }

    public function getTemplateName()
    {
        return "@particles/contenttabs.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  206 => 74,  200 => 72,  195 => 70,  192 => 69,  190 => 68,  185 => 66,  181 => 64,  178 => 63,  165 => 52,  156 => 48,  146 => 44,  140 => 41,  130 => 40,  126 => 39,  122 => 37,  117 => 36,  111 => 34,  109 => 33,  105 => 32,  101 => 30,  97 => 29,  90 => 24,  79 => 19,  75 => 18,  71 => 17,  67 => 15,  63 => 14,  58 => 12,  54 => 10,  48 => 9,  43 => 8,  40 => 7,  33 => 4,  30 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/contenttabs.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\particles\\contenttabs.html.twig");
    }
}
